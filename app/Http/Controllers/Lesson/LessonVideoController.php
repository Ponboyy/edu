<?php

namespace App\Http\Controllers\Lesson;

use App\Actions\Lesson\GetLessonVideoAction;
use App\Http\Controllers\Controller;
use App\Http\Responses\Lesson\LessonVideoResponse;
use App\Models\Lesson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LessonVideoController extends Controller
{
    use AuthorizesRequests;

    public function __invoke(
        Lesson $lesson,
        GetLessonVideoAction $action
    ) {
        $this->authorize('view', $lesson->course);

        return LessonVideoResponse::fromUrl(
            $action->execute($lesson)
        );
    }
}
