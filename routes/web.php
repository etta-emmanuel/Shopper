<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::name('web')->middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::resource('users', UserController::class)->only(['index', 'show', 'edit']);
});

