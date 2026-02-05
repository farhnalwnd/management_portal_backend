<?php

use App\Http\Controllers\ApprovalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/approval/{id}/{token}/{status}', [ApprovalController::class, 'approval'])->name('approval.content');
