<?php

namespace App\Http\Responses\Course;

use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseResponse
{
    public static function fromModel(Course $course): JsonResponse
    {
        $isPurchased = $course->users->isNotEmpty();

        return response()->json([
            'id'          => $course->id,
            'image'       => $course->image,
            'title'       => $course->title,
            'description' => $course->description,
            'price'       => $course->price,

            'is_purchased' => $isPurchased,

            'lessons' => $course->lessons->map(function ($lesson) use ($isPurchased) {
                return [
                    'id'          => $lesson->id,
                    'title'       => $lesson->title,
                    'description' => $lesson->description,

                    // видео только если куплен курс
                    'has_video'   => $isPurchased && $lesson->video !== null,
                ];
            }),
        ]);
    }
}
