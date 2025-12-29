<?php

namespace App\Http\Controllers\Payment;

use App\Actions\Payment\HandleTochkaWebhookAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TochkaWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        HandleTochkaWebhookAction $action
    ) {
        Log::info('Tochka Webhook Payload:', $request->all());

        try {
            $action->execute($request->all());
        } catch (\Exception $e) {
            Log::error('Webhook processing failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'ok']);
    }
}
