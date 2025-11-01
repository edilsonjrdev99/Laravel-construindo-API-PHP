<?php

use App\HTTP\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\Auth\LogoutUserController;
use App\Http\Controllers\Api\Auth\MeUserController;
use App\Http\Controllers\Api\Auth\ChangePasswordUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/', function () {
    return json_encode(['status' => true]);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware('auth:api');;
    Route::get('/{id}', [UserController::class, 'show'])->middleware('auth:api');;
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update'])->middleware('auth:api');;
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('auth:api');;
});

Route::prefix('auth')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/login', [LoginUserController::class, 'login']);
        Route::post('/logout', [LogoutUserController::class, 'logout'])->middleware('auth:api');
        Route::get('/me', [MeUserController::class, 'me'])->middleware('auth:api');
        Route::put('/change-password', [ChangePasswordUserController::class, 'changePassword'])->middleware('auth:api');
    });
});