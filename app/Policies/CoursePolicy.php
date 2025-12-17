<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function view(User $user, Course $course): bool
    {
        return $user
            ->courses()
            ->where('course_id', $course->id)
            ->exists();
    }
}
