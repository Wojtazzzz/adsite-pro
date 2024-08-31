<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Task\Api\Controllers\CategoryController;
use Modules\Task\Api\Controllers\TaskController;
use Modules\Task\Api\Controllers\TeamController;
use Modules\Task\Api\Controllers\UserController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require_once __DIR__ . '/auth.php';

Route::middleware('auth')->name('.api')->group(function () {
    Route::controller(TeamController::class)->prefix('/teams')->name('.teams')->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::post('/', 'store')->name('.store');
        Route::get('/{team}', 'show')->name('.show');
        Route::delete('/{team}', 'destroy')->name('.delete');
        Route::patch('/{team}/rename', 'rename')->name('.rename');

        Route::controller(CategoryController::class)->prefix('/{team}/categories')->name('.categories')->group(function () {
            Route::post('/', 'store')->name('.store');

            Route::controller(TaskController::class)->prefix('/{category}/tasks')->name('.tasks')->group(function () {
                Route::post('/', 'store')->name('.store');
            });
        });

        Route::controller(UserController::class)->prefix('/{team}/users')->name('.users')->group(function () {
            Route::get('/', 'members')->name('.index');
        });
    });

    Route::controller(TaskController::class)->prefix('/tasks')->name('.tasks')->group(function () {
        Route::patch('/{task}/status', 'updateStatus')->name('.update.status');
    });
});


