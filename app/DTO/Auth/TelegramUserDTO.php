<?php

namespace App\DTO\Auth;

class TelegramUserDTO
{
    public function __construct(
        public int $id,
        public ?string $username,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $photo_url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            username: $data['username'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            photo_url: $data['photo_url'] ?? null,
        );
    }
}
