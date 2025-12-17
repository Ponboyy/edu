<?php

namespace App\Http\Controllers\Payment;

use App\Actions\Payment\HandleTochkaWebhookAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TochkaWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        HandleTochkaWebhookAction $action
    ) {
        $action->execute($request->all());

        return response()->json(['ok' => true]);
    }
}
