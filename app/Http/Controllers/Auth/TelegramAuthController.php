<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\TelegramAuthAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TelegramAuthRequest;
use App\Http\Responses\Auth\TelegramAuthResponse;

class TelegramAuthController extends Controller
{
    public function __invoke(
        TelegramAuthRequest $request,
        TelegramAuthAction $action
    ) {
        $result = $action->execute($request->validated()['initData']);

        return TelegramAuthResponse::fromResult($result);
    }
}
