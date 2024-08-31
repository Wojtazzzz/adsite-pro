<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Api\Controllers\AuthenticatedSessionController;
use Modules\Auth\Api\Controllers\RegisteredUserController;

Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/me', [AuthenticatedSessionController::class, 'me'])->name('me');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
