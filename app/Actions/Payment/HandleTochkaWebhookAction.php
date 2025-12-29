<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class HandleTochkaWebhookAction
{
    public function execute(array $payload): void
    {
        $data = $payload['Data'] ?? $payload;

        $externalId = $data['paymentId'] ?? null;
        $statusRaw  = $data['status'] ?? $data['paymentStatus'] ?? null;

        if (! $externalId) {
            throw new Exception('Webhook error: paymentId not found in payload');
        }

        $payment = Payment::where('external_payment_id', $externalId)->first();

        if (! $payment) {
            Log::warning("Webhook: Payment not found for external_id: {$externalId}");
            return;
        }

        if ($payment->status === 'paid') {
            Log::info("Payment {$payment->id} is already paid. Skipping.");
            return;
        }

        $status = strtolower((string)$statusRaw);

        if (in_array($status, ['succeeded', 'executed'])) {
            DB::transaction(function () use ($payment) {
                $payment->update([
                    'status' => 'paid',
                    'updated_at' => now(),
                ]);

                $payment->user->courses()->syncWithoutDetaching([
                    $payment->course_id => ['purchased_at' => now(), 'created_at' => now(), 'updated_at' => now()],
                ]);

                Log::info("Access granted: User {$payment->user_id} -> Course {$payment->course_id}");
            });

        } elseif (in_array($status, ['failed', 'canceled', 'rejected'])) {
            $payment->update(['status' => 'failed']);
            Log::info("Payment {$payment->id} failed with status: {$statusRaw}");
        } else {
            Log::info("Payment {$payment->id} status update: {$statusRaw}");
        }
    }
}
