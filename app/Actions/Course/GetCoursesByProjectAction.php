<?php

namespace App\Actions\Course;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetCoursesByProjectAction
{
    public function execute(int $projectId, User $user): Collection
    {
        return Course::query()
            ->where('project_id', $projectId)
            ->where('is_active', true)
            ->with([
                'users' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ])
            ->get();
    }
}
