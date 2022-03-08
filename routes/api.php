<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\AuthController;

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
Route::post('/issue-token', [AuthController::class, 'issueToken']);
Route::post('/users', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::scopeBindings()
        ->prefix('/users/address')
        ->group(function () {
            Route::get('/', [UserAddressController::class, 'index']);
            Route::get('/{user_address}', [UserAddressController::class, 'show']);
            Route::post('/', [UserAddressController::class, 'store']);
            Route::put('/{user_address}', [UserAddressController::class, 'update']);
            Route::delete('/{user_address}', [UserAddressController::class, 'destroy']);
        });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/', [UserController::class, 'update']);
        Route::delete('/', [UserController::class, 'destroy']);
    });

    Route::get('/me', [UserController::class, 'me']);
});
