<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::patch('/users/{user}/enable', [UserController::class, 'enable']);
    Route::patch('/users/{user}/disable', [UserController::class, 'disable']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);
});
