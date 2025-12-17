<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonVideo;

class ProjectsAndCoursesSeeder extends Seeder
{
    public function run(): void
    {
        $project1 = Project::create([
            'title'       => 'Олимпиада Физтех',
            'image'       => 'projects/phys.png',
            'description' => 'Олимпиада для физиков',
        ]);

        $project2 = Project::create([
            'title'       => 'Олимпиада МГУ',
            'image'       => 'projects/msu.png',
            'description' => 'Олимпиада для школьников',
        ]);

        // ===== Курсы проекта 1 =====
        $courseMath = Course::create([
            'project_id'  => $project1->id,
            'title'       => 'Математика',
            'image'       => 'courses/math.png',
            'price'       => 1000,
            'description' => 'Математика для олимпиад',
            'is_active'   => true,
        ]);

        $coursePhysics = Course::create([
            'project_id'  => $project1->id,
            'title'       => 'Физика',
            'image'       => 'courses/physics.png',
            'price'       => 1200,
            'description' => 'Физика для олимпиад',
            'is_active'   => true,
        ]);

        // ===== Курсы проекта 2 =====
        $courseRussian = Course::create([
            'project_id'  => $project2->id,
            'title'       => 'Русский язык',
            'image'       => 'courses/russian.png',
            'price'       => 900,
            'description' => 'Русский язык для олимпиад',
            'is_active'   => true,
        ]);

        $courseIT = Course::create([
            'project_id'  => $project2->id,
            'title'       => 'Информатика',
            'image'       => 'courses/it.png',
            'price'       => 1100,
            'description' => 'Информатика для олимпиад',
            'is_active'   => true,
        ]);

        // ===== Добавляем уроки и видео для каждого курса =====
        $allCourses = [$courseMath, $coursePhysics, $courseRussian, $courseIT];

        foreach ($allCourses as $course) {
            for ($i = 1; $i <= 3; $i++) { // создаём 3 урока на курс
                $lesson = Lesson::create([
                    'course_id'   => $course->id,
                    'title'       => "Урок $i: {$course->title}",
                    'description' => "Описание урока $i для курса {$course->title}",
                    'sort_order'  => $i,
                ]);

                LessonVideo::create([
                    'lesson_id' => $lesson->id,
                    'path'      => "videos/{$course->id}_lesson_{$i}.mp4", // пример пути к видео
                ]);
            }
        }
    }
}
