<?php

namespace App\Http\Controllers\Api\ProjectResources;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Projects\ProjectResourceResource;
use App\Models\ProjectResource;
use Illuminate\Database\Eloquent\Builder;

class GetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $projectUuid)
    {
        $userId = auth()->id();

        $projectResources = ProjectResource::query()
            ->whereHas('project', fn(Builder $query) => $query->where('uuid', $projectUuid)->where('user_id', $userId))
            ->get();

        return ProjectResourceResource::collection($projectResources);
    }
}
