<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PositionsController;

Route::get('/login', [AuthController::class, 'loginPage'])->name('login_page');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/positions', [PositionsController::class, 'index'])->name('positions');
    Route::get('/rooms', [PositionsController::class, 'rooms'])->name('rooms');
    Route::post('/rooms-create', [PositionsController::class, 'rooms_create'])->name('rooms_create');
    Route::post('/rooms-delete', [PositionsController::class, 'rooms_delete'])->name('rooms_delete');
});
