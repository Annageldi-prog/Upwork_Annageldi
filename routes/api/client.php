<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Client\WorkController;

Route::prefix('client')->group(function () {
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index']);
        Route::post('/', [ClientController::class, 'store']);
        Route::put('/{client}', [ClientController::class, 'update']);
        Route::delete('/{client}', [ClientController::class, 'destroy']);
    });

    Route::get('/works', [WorkController::class, 'index']);
});
