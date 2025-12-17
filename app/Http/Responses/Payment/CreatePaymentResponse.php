<?php

namespace App\Http\Responses\Payment;

use Illuminate\Http\JsonResponse;

class CreatePaymentResponse
{
    public static function fromUrl(string $url): JsonResponse
    {
        return response()->json([
            'payment_url' => $url,
        ]);
    }
}
