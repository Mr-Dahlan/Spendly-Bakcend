<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;

Route::apiResource('budgets', BudgetController::class);
