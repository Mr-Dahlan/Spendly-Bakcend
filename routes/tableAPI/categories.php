<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum','check_banned')->group(function () {
    Route::apiResource('categories', CategoryController::class)
        ->parameters(['categories' => 'id']);
});