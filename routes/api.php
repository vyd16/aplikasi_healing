<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\NotificationController;

/**
 * API Version 1
 */
Route::prefix('api/v1')->group(function () {
    // Auth routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

    // Public routes
    Route::get('/locations', [LocationController::class, 'index']);
    Route::get('/locations/{id}', [LocationController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/locations/{id}/reviews', [ReviewController::class, 'store']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::apiResource('itineraries', ItineraryController::class);
        Route::get('/notifications', [NotificationController::class, 'index']);

        // Admin routes (simple, assuming admin middleware is added later)
        Route::middleware('can:admin')->prefix('admin')->group(function () {
            Route::put('/locations/{id}/approve', [AdminLocationController::class, 'approve']);
        });
    });
});
?>
