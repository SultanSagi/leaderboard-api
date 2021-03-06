<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserPointsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users', [UsersController::class, 'store']);
Route::get('users', [UsersController::class, 'index']);
Route::delete('users/{user}', [UsersController::class, 'destroy']);

Route::post('users/{user}/points', [UserPointsController::class, 'store']);
Route::delete('users/{user}/points', [UserPointsController::class, 'destroy']);
