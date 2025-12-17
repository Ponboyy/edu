<?php

namespace App\Actions\User;

use App\Models\User;

class GetMeAction
{
    public function execute(User $user): User
    {
        return $user->load('courses');
    }
}
