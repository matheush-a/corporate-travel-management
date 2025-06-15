<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\TravelRequestController;

Route::post('/register', [JWTAuthController::class, 'register']);
Route::post('/login', [JWTAuthController::class, 'login']);

Route::middleware('auth.jwt')->group(function () {
    Route::group(['prefix' => ''], function () {
        Route::post('/logout', [JWTAuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'travel-requests'], function () {
        Route::get('/', [TravelRequestController::class, 'index']);
        Route::get('/{id}', [TravelRequestController::class, 'show']);
        Route::post('/', [TravelRequestController::class, 'store']);
        Route::put('/{id}', [TravelRequestController::class, 'update']);
    });
});
