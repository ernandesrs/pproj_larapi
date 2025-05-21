<?php

use App\Http\Controllers\Api\App\AppController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ForgetedPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Me\MeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1'
], function () {

    Route::get('/test', fn() => \App\Helpers\ApiResponse::success());

    Route::group([
        'prefix' => 'app'
    ], function () {

        Route::get('/roles', [AppController::class, 'roles'])
            ->name('app.roles');
        Route::get('/permissions/{layer}', [AppController::class, 'permissions'])
            ->name('app.permissions');

    });

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

        Route::group([
            'middleware' => 'auth:sanctum'
        ], function () {
            Route::post('/register-verify', [RegisterController::class, 'registerVerify'])
                ->name('auth.registerVerify');
            Route::post('/resend-verification', [RegisterController::class, 'resendVerification'])
                ->name('auth.resendVerification');
        });
    });

    Route::group([
        'prefix' => 'password'
    ], function () {

        Route::post('/forget', [ForgetedPasswordController::class, 'passwordForget'])
            ->name('password.forget')->middleware(['throttle:5,1']);
        Route::post('/update', [ForgetedPasswordController::class, 'passwordUpdate'])
            ->name('password.update');

    });

    Route::group([
        'prefix' => 'me',
        'middleware' => ['auth:sanctum']
    ], function () {

        Route::get('/', [MeController::class, 'me'])
            ->name('me');
        Route::get('/roles', [MeController::class, 'roles'])
            ->name('me.roles');

    });

});
