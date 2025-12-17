<?php

namespace App\Http\Responses\Project;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

class ProjectResponse
{
    public static function fromCollection(Collection $projects): JsonResponse
    {
        return response()->json(
            $projects->map(fn(Project $project) => [
                'id'    => $project->id,
                'title' => $project->title,
                'image' => $project->image,
            ])
        );
    }
}
