<?php

namespace App\Services\Telegram;

use App\DTO\Auth\TelegramUserDTO;
use Illuminate\Validation\ValidationException;

class TelegramInitDataValidator
{
    public function validate(string $initData): TelegramUserDTO
    {
        parse_str($initData, $data);

        $hash = $data['hash'] ?? null;
        unset($data['hash']);

        ksort($data);

        $checkString = collect($data)
            ->map(fn ($value, $key) => "{$key}={$value}")
            ->implode("\n");

        $secretKey = hash_hmac(
            'sha256',
            config('services.telegram.bot_token'),
            'WebAppData',
            true
        );

        $calculatedHash = hash_hmac(
            'sha256',
            $checkString,
            $secretKey
        );

        if (! hash_equals($calculatedHash, $hash)) {
            throw ValidationException::withMessages([
                'initData' => 'Invalid Telegram signature',
            ]);
        }

        $user = json_decode($data['user'] ?? '{}', true);

        return TelegramUserDTO::fromArray($user);
    }
}
