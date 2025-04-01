<?php

use App\Http\Controllers\Api\InvitationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
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

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::post('/auth/sendInvite', [InvitationController::class, 'sendInvite']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']); // Aberto a todos
    Route::get('/products/{id}', [ProductController::class, 'show']); // Aberto a todos

    Route::middleware(['admin_or_moderator'])->group(function () {
        Route::post('/products', [ProductController::class, 'store']); // Criar produto
        Route::put('/products/{id}', [ProductController::class, 'update']); // Editar produto
        Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Remover produto
    });
});
