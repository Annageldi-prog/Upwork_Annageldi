<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\DashboardController;
use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Client\WorkController;

Route::prefix('client')->middleware(['auth:sanctum', 'role:client'])->group(function () {

    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);


    Route::get('/works', [WorkController::class, 'index']);
});
