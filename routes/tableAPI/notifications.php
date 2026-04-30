<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Route untuk user
Route::middleware('auth:sanctum')->group(function () {
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);
});

// Route khusus admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('admin/notifications/send', [NotificationController::class, 'send']);
});