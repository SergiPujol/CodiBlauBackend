<?php

use App\Http\Controllers\Api\ActionController;
use App\Http\Controllers\Api\CycleController;
use App\Http\Controllers\Api\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('sessions')->group(function () {
    Route::post('/', [SessionController::class, 'store']); // crear sessió
    Route::get('/{id}', [SessionController::class, 'show']);
    Route::post('/{id}/actions', [ActionController::class, 'store']); // afegir acció
    Route::post('/{id}/cycles', [CycleController::class, 'store']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
