<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/auth/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware(['portal.token', 'auth:sanctum'])->group(function () {
    Route::get('/v1/me', [DashboardController::class, 'me']);
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
    Route::get('/v1/my-dashboard', [DashboardController::class, 'index']);
    Route::post('/v1/auth/sso-ticket', [AuthController::class, 'generateTicket']);
});
