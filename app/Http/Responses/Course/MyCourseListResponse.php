<?php

namespace App\Http\Responses\Course;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class MyCourseListResponse
{
    public static function fromCollection(Collection $courses): JsonResponse
    {
        return response()->json(
            $courses->map(function ($course) {
                return [
                    'id'           => $course->id,
                    'title'        => $course->title,
                    'description'  => $course->description,
                    'price'        => $course->price,
                    'purchased_at' => $course->pivot->purchased_at,
                ];
            })
        );
    }
}
