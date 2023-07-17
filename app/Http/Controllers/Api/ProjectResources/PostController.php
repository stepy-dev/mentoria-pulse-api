<?php

namespace App\Http\Controllers\Api\ProjectResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectResources\StoreRequest;
use App\Http\Resources\Api\Projects\ProjectResourceResource;
use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request, string $projectUuid)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $project = Project::where('uuid', $projectUuid)->firstOrFail();

            $validatedData['project_id'] = $project->id;
            $validatedData['uuid'] = (string) Str::uuid();

            if(isset($validatedData['settings'])) {
                $validatedData['settings'] = json_decode($validatedData['settings']);
            }

            $projectResource = $project->resources()->create($validatedData);

            DB::commit();

            return new ProjectResourceResource($projectResource);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            abort(500, 'We were unable to create the resource. Try again.');
        }
    }
}
