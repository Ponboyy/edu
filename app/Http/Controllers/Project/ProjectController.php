<?php

namespace App\Http\Controllers\Project;

use App\Actions\Project\GetProjectsAction;
use App\Http\Controllers\Controller;
use App\Http\Responses\Project\ProjectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(
        Request $request,
        GetProjectsAction $action
    ) {
        return ProjectResponse::fromCollection(
            $action->execute()
        );
    }
}
