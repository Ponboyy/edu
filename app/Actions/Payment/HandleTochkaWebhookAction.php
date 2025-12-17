<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HandleTochkaWebhookAction
{
    public function execute(array $payload): void
    {
        $payment = Payment::where('id', $payload['order_id'])
            ->where('status', 'pending')
            ->first();

        if (! $payment) {
            throw new NotFoundHttpException();
        }

        if ($payload['status'] !== 'paid') {
            $payment->update(['status' => 'failed']);
            return;
        }

        DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'paid']);

            $payment->user->courses()->syncWithoutDetaching([
                $payment->course_id => ['purchased_at' => now()],
            ]);
        });
    }
}
