<?php

namespace App\Http\Controllers\Payment;

use App\Actions\Payment\CreateCoursePaymentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreateCoursePaymentRequest;
use App\Http\Responses\Payment\CreatePaymentResponse;
use App\Models\Course;

class CreateCoursePaymentController extends Controller
{
    public function __invoke(
        CreateCoursePaymentRequest $request,
        CreateCoursePaymentAction $action
    ) {
        $course = Course::findOrFail($request->course_id);

        return CreatePaymentResponse::fromUrl(
            $action->execute($request->user(), $course)
        );
    }
}
