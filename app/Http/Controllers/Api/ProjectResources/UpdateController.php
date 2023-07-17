<?php

namespace App\Http\Controllers\Api\ProjectResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProjectResources\StoreRequest;
use App\Models\ProjectResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request, string $projectUuid, string $resourceUuid)
    {
        $validatedData = $request->validated();
        $userId = auth()->id();

        DB::beginTransaction();

        try {
            $projectResource = ProjectResource::where('uuid', $resourceUuid)
                ->whereHas('project', fn(Builder $query) => $query->where('user_id', $userId)->where('uuid', $projectUuid))
                ->firstOrFail();

            if(isset($validatedData['settings'])) {
                $validatedData['settings'] = json_decode($validatedData['settings']);
            }

            $projectResource->fill($validatedData);
            $projectResource->save();

            DB::commit();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            abort(500, 'We were unable to update the resource. Try again.');
        }
    }
}
