<?php

namespace App\Http\Controllers\User;

use App\Actions\User\GetMeAction;
use App\Http\Controllers\Controller;
use App\Http\Responses\User\MeResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(
        Request $request,
        GetMeAction $action
    ) {
        return MeResponse::fromUser(
            $action->execute($request->user())
        );
    }
}
