<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Api\Controllers\AuthenticatedSessionController;
use Modules\Auth\Api\Controllers\RegisteredUserController;
use Modules\Task\Api\Controllers\CategoryController;
use Modules\Task\Api\Controllers\InvitationController;
use Modules\Task\Api\Controllers\TaskController;
use Modules\Task\Api\Controllers\TeamController;
use Modules\Task\Api\Controllers\UserController;

Route::name('api.')->group(function () {
    Route::name('auth.')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
            Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/me', [AuthenticatedSessionController::class, 'me'])->name('me');
            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::controller(TeamController::class)->prefix('/teams')->name('teams.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{team}', 'show')->name('show');
            Route::delete('/{team}', 'destroy')->name('delete');
            Route::patch('/{team}/rename', 'rename')->name('rename');

            Route::controller(CategoryController::class)->prefix('/{team}/categories')->name('categories.')->group(function () {
                Route::post('/', 'store')->name('store');

                Route::controller(TaskController::class)->prefix('/{category}/tasks')->name('tasks.')->group(function () {
                    Route::post('/', 'store')->name('store');
                    Route::patch('/{task}/status', 'updateStatus')->name('update.status');
                });
            });

            Route::controller(UserController::class)->prefix('/{team}/users')->name('users.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/details', 'details')->name('details');
                Route::delete('/{user}', 'destroy')->name('destroy');
            });

            Route::controller(InvitationController::class)->prefix('/{team}/invitations')->name('invitations.')->group(function () {
                Route::post('/', 'store')->name('store');
            });
        });

        Route::controller(InvitationController::class)->prefix('/invitations')->name('invitations.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::patch('/{invitation}', 'update')->name('update');
        });
    });
});


