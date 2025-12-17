<?php

namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class GetProjectsAction
{
    public function execute(): Collection
    {
        return Project::query()
            ->orderBy('id')
            ->get();
    }
}
