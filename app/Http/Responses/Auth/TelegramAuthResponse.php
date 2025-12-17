<?php

namespace App\Http\Responses\Auth;

use Illuminate\Http\JsonResponse;

class TelegramAuthResponse
{
    public static function fromResult(array $result): JsonResponse
    {
        return response()->json([
            'token' => $result['token'],
            'user'  => [
                'id'         => $result['user']->id,
                'telegram_id'=> $result['user']->telegram_id,
                'username'   => $result['user']->username,
                'first_name' => $result['user']->first_name,
                'last_name'  => $result['user']->last_name,
                'photo_url'  => $result['user']->photo_url,
            ],
        ]);
    }
}
