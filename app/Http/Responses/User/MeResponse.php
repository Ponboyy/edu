<?php

namespace App\Http\Responses\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class MeResponse
{
    public static function fromUser(User $user): JsonResponse
    {
        return response()->json([
            'id'          => $user->id,
            'telegram_id' => $user->telegram_id,
            'username'    => $user->username,
            'first_name'  => $user->first_name,
            'last_name'   => $user->last_name,
            'photo_url'   => $user->photo_url,

            'courses' => $user->courses->map(fn ($course) => [
                'id'           => $course->id,
                'title'        => $course->title,
                'purchased_at' => $course->pivot->purchased_at,
            ]),
        ]);
    }
}
