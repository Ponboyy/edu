<?php

namespace App\Actions\Auth;

use App\DTO\Auth\TelegramUserDTO;
use App\Models\User;
use App\Services\Telegram\TelegramInitDataValidator;
use Illuminate\Support\Facades\DB;

class TelegramAuthAction
{
    public function __construct(
        private TelegramInitDataValidator $validator
    ) {}

    public function execute(string $initData): array
    {
        $telegramUser = $this->validator->validate($initData);

        return DB::transaction(function () use ($telegramUser) {
            $user = User::updateOrCreate(
                ['telegram_id' => $telegramUser->id],
                [
                    'username'   => $telegramUser->username,
                    'first_name' => $telegramUser->first_name,
                    'last_name'  => $telegramUser->last_name,
                    'photo_url'  => $telegramUser->photo_url,
                ]
            );

            $token = $user->createToken('telegram')->plainTextToken;

            return [
                'user'  => $user,
                'token' => $token,
            ];
        });
    }
}
