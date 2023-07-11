<?php

namespace App\Http\Controllers\Api\ProjectResources;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Projects\ProjectResourceResource;
use App\Models\ProjectResource;
use Illuminate\Database\Eloquent\Builder;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $projectUuid, string $resourceUuid)
    {
        $userId = auth()->id();

        $projectResource = ProjectResource::query()
            ->whereHas('project', fn(Builder $query) => $query->where('uuid', $projectUuid)->where('user_id', $userId))
            ->where('uuid', $resourceUuid)
            ->firstOrFail();

        return new ProjectResourceResource($projectResource);
    }
}
