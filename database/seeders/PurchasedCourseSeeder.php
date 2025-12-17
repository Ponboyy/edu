<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonVideo;
use App\Models\Payment;

class PurchasedCourseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['telegram_id' => 9343299],
            [
                'username'   => 'dev_user',
                'first_name' => 'Dev',
                'last_name'  => 'User',
                'photo_url'  => null,
            ]
        );

        $course = Course::firstOrCreate(
            ['title' => 'Тестовый курс'],
            [
                'image'       => 'courses/test.png',
                'price'       => 1000,
                'description' => 'Курс для локального теста',
            ]
        );

        for ($i = 1; $i <= 3; $i++) {
            $lesson = Lesson::firstOrCreate(
                ['course_id' => $course->id, 'title' => "Урок $i"],
                []
            );

            LessonVideo::firstOrCreate(
                ['lesson_id' => $lesson->id],
                ['path' => 'videos/sample.mp4']
            );
        }

        Payment::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            [
                'amount'              => $course->price,
                'status'              => 'paid',
                'external_payment_id' => 'TEST_PAYMENT_1',
            ]
        );
    }
}
