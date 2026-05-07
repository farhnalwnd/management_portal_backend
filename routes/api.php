<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Middleware\PortalTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::get('/v1/auth/refresh', [AuthController::class, 'refresh']);

Route::middleware([PortalTokenMiddleware::class, 'auth:sanctum'])->group(function () {
    Route::get('/v1/me', [DashboardController::class, 'me']);
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
    Route::get('/v1/my-dashboard', [DashboardController::class, 'index']);
    Route::post('/v1/auth/sso-ticket', [AuthController::class, 'generateTicket']);
});
