<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function() {
    Route::post('/sign-in', [\App\Http\Controllers\Api\Auth\SignInController::class, '__invoke'])->name('api.auth.sign-in');
});

Route::group(['prefix' => 'projects', 'middleware' => ['auth:sanctum']], function() {
    Route::get('/', [\App\Http\Controllers\Api\Projects\GetController::class, '__invoke'])->name('api.projects.get');
    Route::post('/', [\App\Http\Controllers\Api\Projects\PostController::class, '__invoke'])->name('api.projects.post');
    Route::get('/{projectUuid}', [\App\Http\Controllers\Api\Projects\ShowController::class, '__invoke'])->name('api.projects.show');
    Route::put('/{projectUuid}', [\App\Http\Controllers\Api\Projects\UpdateController::class, '__invoke'])->name('api.projects.update');
    Route::delete('/{projectUuid}', [\App\Http\Controllers\Api\Projects\DeleteController::class, '__invoke'])->name('api.projects.delete');
});

Route::group(['prefix' => 'projects/{projectUuid}/resources', 'middleware' => ['auth:sanctum']], function() {
    Route::get('/', [\App\Http\Controllers\Api\ProjectResources\GetController::class, '__invoke'])->name('api.project_resources.get');
    Route::post('/', [\App\Http\Controllers\Api\ProjectResources\PostController::class, '__invoke'])->name('api.project_resources.post');
    Route::get('/{resourceUuid}', [\App\Http\Controllers\Api\ProjectResources\ShowController::class, '__invoke'])->name('api.project_resources.show');
    Route::put('/{resourceUuid}', [\App\Http\Controllers\Api\ProjectResources\UpdateController::class, '__invoke'])->name('api.project_resources.put');
    Route::delete('/{resourceUuid}', [\App\Http\Controllers\Api\ProjectResources\DeleteController::class, '__invoke'])->name('api.project_resources.delete');
});
