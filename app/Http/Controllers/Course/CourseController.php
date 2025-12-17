<?php

namespace App\Http\Controllers\Course;

use App\Actions\Course\GetCourseAction;
use App\Actions\Course\GetCoursesAction;
use App\Actions\Course\GetCoursesByProjectAction;
use App\Http\Controllers\Controller;
use App\Http\Responses\Course\CourseListResponse;
use App\Http\Responses\Course\CourseResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(
        Request $request,
        GetCoursesAction $action
    ) {
        return CourseListResponse::fromCollection(
            $action->execute($request->user())
        );
    }

    public function show(
        Request $request,
        GetCourseAction $action,
        int $projectId,
        int $id
    ) {
        return CourseResponse::fromModel(
            $action->execute($id, $projectId, $request->user())
        );
    }

    public function indexByProject(
        int $project,
        Request $request,
        GetCoursesByProjectAction $action
    ) {
        return CourseListResponse::fromCollection(
            $action->execute($project, $request->user())
        );
    }

}
