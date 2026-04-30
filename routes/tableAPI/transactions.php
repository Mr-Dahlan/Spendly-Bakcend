<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('transactions',          [TransactionController::class, 'index']);
    Route::post('transactions',         [TransactionController::class, 'store']);
    Route::get('transactions/{id}',     [TransactionController::class, 'show']);
    Route::patch('transactions/{id}',   [TransactionController::class, 'update']); // ← PATCH
    Route::delete('transactions/{id}',  [TransactionController::class, 'destroy']);
});