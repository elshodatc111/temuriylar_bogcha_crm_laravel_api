<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController,EmploesController,RoomController,SettingController};

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::post('/room-create', [RoomController::class, 'create']);
    Route::post('/room-delete', [RoomController::class, 'delete']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/emploes', [EmploesController::class, 'index']);
    Route::get('/emploes-end', [EmploesController::class, 'index_end']);
    Route::get('/get-position', [EmploesController::class, 'get_position']);
    Route::post('/emploes-create', [EmploesController::class, 'create']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/setting-sms', [SettingController::class, 'sms']);
    Route::post('/setting-sms-update', [SettingController::class, 'sms_update']);
    Route::get('/setting-paymart', [SettingController::class, 'paymart']);
    Route::post('/setting-paymart-update', [SettingController::class, 'paymart_update']);
});
