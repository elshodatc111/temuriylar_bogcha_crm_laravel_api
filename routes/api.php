<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
