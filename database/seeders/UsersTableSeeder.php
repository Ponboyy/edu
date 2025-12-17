<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'telegram_id' => 993993969,
            'username'    => 'dev_user',
            'first_name'  => 'Dev',
            'last_name'   => 'User',
            'photo_url'   => null,
        ]);

    }
}
