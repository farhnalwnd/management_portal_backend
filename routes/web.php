<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\SsoController;
use Illuminate\Support\Facades\Route;

Route::get('/approval/{id}/{token}/{status}', [ApprovalController::class, 'approval'])->name('approval.content');
Route::get('/approval/menu-schedule/{id}/{token}/{status}', [ApprovalController::class, 'menuScheduleApproval'])->name('approval.menu_schedule');
Route::get('/sso/verify', [SsoController::class, 'verify'])->name('sso.verify');
// Route::post('/logout', [SsoController::class, 'destroy'])->name('logout.app');
