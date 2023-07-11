<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Projects\ProjectResource;
use App\Models\Project;

class GetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $userId = auth()->id();

        $projects = Project::query()
            ->withCount(['resources'])
            ->where('user_id', $userId)
            ->get();

        return ProjectResource::collection($projects);
    }
}
