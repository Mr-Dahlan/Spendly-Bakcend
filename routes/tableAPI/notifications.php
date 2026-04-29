<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::apiResource('notifications', NotificationController::class);
