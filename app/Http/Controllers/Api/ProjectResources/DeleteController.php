<?php

namespace App\Http\Controllers\Api\ProjectResources;

use App\Http\Controllers\Controller;
use App\Models\ProjectResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $projectUuid, string $resourceUuid)
    {
        DB::beginTransaction();

        try {
            $userId = auth()->id();

            $projectResource = ProjectResource::where('uuid', $resourceUuid)
                ->whereHas('project', fn(Builder $query) => $query->where('user_id', $userId)->where('uuid', $projectUuid))
                ->firstOrFail();

            $projectResource->delete();

            DB::commit();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            Log::error($exception);

            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);

            abort(500, 'We were unable to delete the resource. Try again.');
        }
    }
}
