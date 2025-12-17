<?php

namespace App\Http\Controllers\Course;

use App\Actions\Course\GetMyCoursesAction;
use App\Http\Controllers\Controller;
use App\Http\Responses\Course\MyCourseListResponse;
use Illuminate\Http\Request;

class MyCoursesController extends Controller
{
    public function __invoke(
        Request $request,
        GetMyCoursesAction $action
    ) {
        return MyCourseListResponse::fromCollection(
            $action->execute($request->user())
        );
    }
}
