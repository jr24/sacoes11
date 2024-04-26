<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/listSastres', [UserController::class, 'listSastres']);
    Route::get('/users/listClientes', [UserController::class, 'listClientes']);
    Route::apiResource('users', UserController::class);
    Route::patch('/users/{user}/enable', [UserController::class, 'enable']);
    Route::patch('/users/{user}/disable', [UserController::class, 'disable']);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('details', DetailController::class);
    Route::get('details/{detail}/statuses/last', [StatusController::class, 'showLastStatus']);
    Route::apiResource('details/{detail}/statuses', StatusController::class);
    Route::get('/auth/logout', [AuthController::class, 'logout']);
});
