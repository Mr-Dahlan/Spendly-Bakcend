<?php

use App\Http\Controllers\AdminLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::get('admin/logs',       [AdminLogController::class, 'index']);
    Route::get('admin/logs/mine',  [AdminLogController::class, 'myLogs']);
});