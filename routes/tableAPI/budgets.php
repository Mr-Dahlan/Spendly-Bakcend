<?php

use App\Http\Controllers\BudgetController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('budgets',          [BudgetController::class, 'index']);
    Route::post('budgets',         [BudgetController::class, 'store']);
    Route::get('budgets/{id}',     [BudgetController::class, 'show']);
    Route::patch('budgets/{id}',   [BudgetController::class, 'update']);
    Route::delete('budgets/{id}',  [BudgetController::class, 'destroy']);
});