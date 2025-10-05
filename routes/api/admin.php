<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\SkillController;
use Illuminate\Support\Facades\Route;


Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);


Route::prefix('v1/admin')
    ->group(function () {
        Route::controller(AuthController::class)
            ->middleware('throttle:10,1')
            ->group(function () {
                Route::post('login', 'login');
                Route::post('logout', 'logout')->middleware('auth:sanctum');
            });

        Route::middleware('auth:sanctum')
            ->prefix('auth')
            ->group(function () {
                Route::controller(DashboardController::class)
                    ->group(function () {
                        Route::get('dashboard', 'index');
                    });
            });
    });

