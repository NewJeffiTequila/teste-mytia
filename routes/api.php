<?php

use App\Http\Controllers\Api\InvitationController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::post('/forgot-password', [UserController::class, 'sendResetLink']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/sendInvite', [InvitationController::class, 'sendInvite'])->middleware('admin');
});
