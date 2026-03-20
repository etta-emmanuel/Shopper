<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::apiResource('users', UserController::class);
