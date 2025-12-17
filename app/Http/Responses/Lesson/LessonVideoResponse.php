<?php

namespace App\Http\Responses\Lesson;

use Illuminate\Http\JsonResponse;

class LessonVideoResponse
{
    public static function fromUrl(string $url): JsonResponse
    {
        return response()->json([
            'video_url' => $url,
        ]);
    }
}
