<?php

use App\Http\Controllers\Auth\TelegramAuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\MyCoursesController;
use App\Http\Controllers\Dev\DevAuthController;
use App\Http\Controllers\Lesson\LessonVideoController;
use App\Http\Controllers\Payment\CreateCoursePaymentController;
use App\Http\Controllers\Payment\TochkaWebhookController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\User\MeController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/telegram', TelegramAuthController::class);

Route::get('/projects', [ProjectController::class, 'index']);
Route::middleware('auth:sanctum')->get('/me', MeController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
});
Route::middleware('auth:sanctum')->get(
    '/projects/{project}/courses/{course}',
    [CourseController::class, 'show']
);
Route::middleware('auth:sanctum')->get(
    '/projects/{project}/courses',
    [CourseController::class, 'indexByProject']
);
Route::middleware('auth:sanctum')->get(
    '/lessons/{lesson}/video',
    LessonVideoController::class
);
Route::middleware('auth:sanctum')->get(
    '/my/courses',
    MyCoursesController::class
);
Route::middleware('auth:sanctum')->post(
    '/payments/course',
    CreateCoursePaymentController::class
);
Route::post(
    '/payments/webhook/tochka',
    TochkaWebhookController::class
);

Route::get('/setup-webhook', function () {
    $token      = config('services.tochka.token');
    $baseUrl    = config('services.tochka.base_url');
    $clientId   = config('services.tochka.client_id');

    $webhookUrl = 'https://tolkopoluybvi.ru/api/webhooks/tochka';

    $events = [
        'incoming_payment',
        'acquiring_operation'
    ];

    $response = Http::withToken($token)
        ->withHeaders(['Content-Type' => 'application/json'])
        ->put("{$baseUrl}/webhook/v1.0/{$clientId}", [
            'url' => $webhookUrl,
            'webhooksList' => $events
        ]);

    return $response->json();
});


if (app()->isLocal()) {
    Route::post('/dev/login', DevAuthController::class);
}
