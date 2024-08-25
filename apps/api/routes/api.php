<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Task\Api\TaskController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->prefix('/tasks')->name('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('.index');
});

require __DIR__ . '/auth.php';
