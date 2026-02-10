<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::get('/v1/auth/logout', [AuthController::class, 'logout']);
Route::get('/v1/auth/refresh', [AuthController::class, 'refresh']);

Route::get('/v1/dashboard', [DashboardController::class, 'index'])->middleware('auth:sanctum');
