<?php

namespace App\Actions\Lesson;

use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetLessonVideoAction
{
    public function execute(Lesson $lesson): string
    {
        if (! $lesson->video) {
            throw new NotFoundHttpException('Video not found');
        }

        return Storage::temporaryUrl(
            $lesson->video->path,
            now()->addMinutes(10)
        );
    }
}
