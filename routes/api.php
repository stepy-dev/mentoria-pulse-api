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
    Route::get('/', function() {
        return ['projects' => []];
    });
});
