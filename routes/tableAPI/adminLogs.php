<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLogController;

Route::apiResource('admin-logs', AdminLogController::class);
