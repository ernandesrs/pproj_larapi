<?php

use App\Http\Controllers\Api\Admin\RolesController;
use App\Http\Controllers\Api\Admin\UsersController;
use App\Http\Controllers\Api\App\ApplicationController;
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

    Route::group([
        'prefix' => 'app'
    ], function () {

        Route::get('/layers', [ApplicationController::class, 'layers'])
            ->name('app.layers');
        Route::get('/roles', [ApplicationController::class, 'roles'])
            ->name('app.roles');
        Route::get('/permissions/{layer}', [ApplicationController::class, 'permissions'])
            ->name('app.permissions');

    });

    Route::group([
        'prefix' => 'admin',
        'middleware' => [
            'auth:sanctum',
            'admin_access'
        ]
    ], function () {

        Route::get('/test', fn() => \App\Helpers\ApiResponse::success());

        Route::group([
            'prefix' => 'users'
        ], function () {

            Route::get('/', [UsersController::class, 'index']);
            Route::post('/create', [UsersController::class, 'store']);
            Route::get('/{user}/show', [UsersController::class, 'show']);
            Route::put('/{user}/update', [UsersController::class, 'update']);
            Route::delete('/{user}/delete', [UsersController::class, 'destroy']);
            Route::patch('/{user}/promote/{role}', [UsersController::class, 'promote']);
            Route::patch('/{user}/demote/{role}', [UsersController::class, 'demote']);

        });

        Route::group([
            'prefix' => 'roles'
        ], function () {

            Route::get('/', [RolesController::class, 'index']);
            Route::post('/create', [RolesController::class, 'store']);
            Route::get('/{role}/show', [RolesController::class, 'show']);
            Route::put('/{role}/update', [RolesController::class, 'update']);

        });

    });

});
