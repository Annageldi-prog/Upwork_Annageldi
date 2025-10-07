<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\SkillController;




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

                Route::controller(UserController::class)
                    ->prefix('users')
                    ->group(function () {
                        Route::get('', 'index');
                        Route::post('', 'store');
                        Route::post('{id}', 'update')->where(['id' => '[0-9]+']);
                        Route::delete('{id}', 'destroy')->where(['id' => '[0-9]+']);
                    });

                Route::controller(LocationController::class)
                    ->prefix('locations')
                    ->group(function () {
                        Route::get('', 'index');
                    });


                Route::controller(SkillController::class)
                    ->prefix('skills')
                    ->group(function () {
                        Route::get('', 'index');
                    });


                Route::controller(ClientController::class)
                    ->prefix('clients')
                    ->group(function () {
                        Route::get('', 'index');
                        Route::post('', 'store');
                        Route::post('{id}', 'update')->where(['id' => '[0-9]+']);
                        Route::delete('{id}', 'destroy')->where(['id' => '[0-9]+']);
                    });

                Route::controller(WorkController::class)
                    ->prefix('works')
                    ->group(function () {
                        Route::get('', 'index');
                    });


            });
    });

