<?php

namespace App\Http\Responses\Course;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CourseListResponse
{
    public static function fromCollection(Collection $courses): JsonResponse
    {
        return response()->json(
            $courses->map(function ($course) {
                return [
                    'id'          => $course->id,
                    'project_id'  => $course->project_id,
                    'image'       => $course->image,
                    'title'       => $course->title,
                    'description' => $course->description,
                    'price'       => $course->price,

                    'is_purchased' => $course->users->isNotEmpty(),
                ];
            })
        );
    }
}
