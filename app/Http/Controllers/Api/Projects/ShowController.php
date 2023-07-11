<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Projects\ProjectResource;
use App\Models\Project;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $projectUuid)
    {
        $userId = auth()->id();

        $project = Project::query()
            ->withCount(['resources'])
            ->where('uuid', $projectUuid)
            ->where('user_id', $userId)
            ->firstOrFail();

        return new ProjectResource($project);
    }
}
