<?php

use App\Http\Controllers\Api\{
    UserController
};
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/users', [UserController::class, 'index']);
// Route::post('/users', [UserController::class, 'store']);
// Route::get('/users/{email}', [UserController::class, 'show']);
// Route::put('/users/{email}', [UserController::class, 'update']);
// Route::delete('/users/{email}', [UserController::class, 'destroy']);

Route::apiResource('users', UserController::class);
