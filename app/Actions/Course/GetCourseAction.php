<?php

namespace App\Actions\Course;

use App\Models\Course;
use App\Models\User;

class GetCourseAction
{
    public function execute(int $courseId, int $projectId, User $user): Course
    {
        return Course::query()
            ->where('id', $courseId)
            ->where('project_id', $projectId)
            ->where('is_active', true)
            ->with([
                'lessons.video',
                'users' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ])
            ->firstOrFail();
    }
}
