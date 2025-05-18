<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1'
], function () {

    Route::get('/test', fn() => \App\Helpers\ApiResponse::success());

    Route::group([
        'prefix' => 'auth'
    ], function () {

        Route::group([
            'middleware' => 'guest:sanctum'
        ], function () {
            Route::post('/register', [RegisterController::class, 'store'])
                ->name('auth.register');
            Route::post('/login', [LoginController::class, 'login'])
                ->name('auth.login');
        });
        Route::get('/verify', [RegisterController::class, 'verify'])
            ->name('auth.verify');
    });

});
