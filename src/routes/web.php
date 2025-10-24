<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

Route::prefix('api')->group(function () {
    Route::get('/', function () {
        return json_encode(['status' => true]);
    });

    Route::get('/users', [UserController::class, 'index']);
});
