<?php

namespace App\Actions\Payment;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateCoursePaymentAction
{
    public function execute(User $user, Course $course): string
    {
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            throw ValidationException::withMessages([
                'course' => 'Этот курс уже был куплен ранее.',
            ]);
        }

        $payment = Payment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'amount'    => $course->price,
            'provider'  => 'tochka',
            'status'    => 'pending',
        ]);

        $baseUrl = config('services.tochka.base_url');
        $token   = config('services.tochka.token');
        $url     = $baseUrl . '/acquiring/v1.0/payments';
        $customerCode = config('services.tochka.customer_code');
        $requestId = (string) Str::uuid();

        $payload = [
            'Data' => [
                'customerCode' => $customerCode,
                'paymentMode'  => ['sbp', 'card'],
                'amount'    => (float) $course->price,
                'currency'  => 'RUB',
                'purpose'   => "Оплата курса: {$course->title}",
                'paymentDetails' => "Заказ №{$payment->id}",
                'redirectUrls'   => [
                    'onSuccess' => config('app.frontend_url') . "/payment/success?order_id={$payment->id}",
                    'onFail'    => config('app.frontend_url') . "/payment/fail?order_id={$payment->id}",
                ],
            ]
        ];

        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                    'X-Request-Id' => $requestId,
                ])
                ->post($url, $payload);

            if ($response->failed()) {
                Log::error('Tochka Acquiring Error', [
                    'payment_id' => $payment->id,
                    'status'     => $response->status(),
                    'body'       => $response->json(),
                    'request_id' => $requestId
                ]);

                throw new Exception('Ошибка создания платежа в банке. Попробуйте позже.');
            }

            $responseData = $response->json();

        } catch (Exception $e) {
            $payment->update(['status' => 'failed']);
            throw $e;
        }

        $paymentUrl = $responseData['Data']['paymentUrl'] ?? null;
        $externalId = $responseData['Data']['paymentId'] ?? null;

        if (!$paymentUrl) {
            Log::error('Tochka API: No paymentUrl returned', ['response' => $responseData]);
            $payment->update(['status' => 'failed']);
            throw new Exception('Банк не вернул ссылку на оплату.');
        }

        $payment->update([
            'external_payment_id' => $externalId,
        ]);

        return $paymentUrl;
    }
}
