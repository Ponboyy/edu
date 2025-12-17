<?php

namespace App\Actions\Course;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetMyCoursesAction
{
    public function execute(User $user): Collection
    {
        return $user
            ->courses()
            ->where('is_active', true)
            ->get();
    }
}
