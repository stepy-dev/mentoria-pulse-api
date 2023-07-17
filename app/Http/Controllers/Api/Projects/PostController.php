<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Projects\StoreRequest;
use App\Http\Resources\Api\Projects\ProjectResource;
use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request)
    {
        $valdiatedData = $request->validated();
        $userId = auth()->id();

        DB::beginTransaction();

        try {
            $project = Project::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $userId,
                'name' =>  $valdiatedData['name'],
            ]);

            $project->loadCount(['resources']);

            DB::commit();

            return new ProjectResource($project);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            abort(500, 'We were unable to create the project. Try again.');
        }
    }
}
