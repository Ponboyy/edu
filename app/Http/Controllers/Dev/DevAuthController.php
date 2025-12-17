<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DevAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::firstOrCreate(
            ['telegram_id' => 9343299],
            [
                'username'   => 'dev_user',
                'first_name' => 'Dev',
                'last_name'  => 'User',
            ]
        );

        $token = $user->createToken('dev')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user_id' => $user->id,
        ]);
    }
}
