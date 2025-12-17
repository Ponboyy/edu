<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\User;
use App\Models\Course;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $course = Course::first();

        Payment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'amount'    => $course->price,
            'status'    => 'paid',
            'external_payment_id' => 'TEST123',
        ]);
    }
}
