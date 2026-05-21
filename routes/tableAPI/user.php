<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Route::apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::patch('/users/update-profile', [UserController::class, 'userUpdate']);

    Route::middleware('is_admin','check_banned')->group(function () {
        Route::get('/users',         [UserController::class, 'index']);
        Route::get('/users/{id}',    [UserController::class, 'show']);
        Route::patch('/users/{id}',  [UserController::class, 'adminUpdate']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::patch('/admin/users/{id}/status', [UserController::class, 'updateStatus']);
        Route::patch('/admin/users/{id}/role',   [UserController::class, 'updateRole']);
    });
});
