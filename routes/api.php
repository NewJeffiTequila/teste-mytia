<?php

use App\Http\Controllers\Api\InvitationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\ReviewController;

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
    Route::get('/movies/search', [MoviesController::class, 'searchMovie']);
    Route::post('/movies/favorite', [MoviesController::class, 'addFavorite']);
    Route::get('/movies/favorites', [MoviesController::class, 'listFavorites']);
    Route::delete('/movies/favorite/{imdb_id}', [MoviesController::class, 'removeFavorite']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/reviews/{title}', [ReviewController::class, 'listByTitle']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->middleware('admin');
});
