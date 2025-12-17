<?php

namespace App\Actions\Payment;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class CreateCoursePaymentAction
{
    public function execute(User $user, Course $course): string
    {
        // защита от повторной покупки
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            throw ValidationException::withMessages([
                'course' => 'Course already purchased',
            ]);
        }

        $payment = Payment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'amount'    => $course->price,
            'status'    => 'pending',
        ]);

        $response = Http::withToken(config('services.tochka.token'))
            ->post(config('services.tochka.create_payment_url'), [
                'amount' => $course->price,
                'order_id' => $payment->id,
                'description' => $course->title,
                'success_url' => config('app.frontend_url'),
            ])
            ->throw();

        $payment->update([
            'external_payment_id' => $response['payment_id'],
        ]);

        return $response['payment_url'];
    }
}
