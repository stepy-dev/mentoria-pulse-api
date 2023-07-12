<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $projectUuid)
    {
        $userId = auth()->id();

        $project = Project::where('uuid', $projectUuid)
            ->where('user_id', $userId)
            ->firstOrFail();

        $project->delete();

        return response()->json(null, 204);
    }
}
