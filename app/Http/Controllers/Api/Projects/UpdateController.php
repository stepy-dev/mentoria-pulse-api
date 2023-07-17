<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Projects\UpdateRequest;
use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, string $projectUuid)
    {
        $validatedData = $request->validated();
        $userId = auth()->id();

        try {
            $project = Project::where('uuid', $projectUuid)
                ->where('user_id', $userId)
                ->firstOrFail();

            $project->name = $validatedData['name'];
            $project->save();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            Log::error($exception);

            abort(500, 'We were unable to update the project. Try again.');
        }
    }
}
