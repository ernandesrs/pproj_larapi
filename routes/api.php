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
            'middleware' => ['guest:sanctum', 'captcha']
        ], function () {
            Route::post('/register', [RegisterController::class, 'store']);
            Route::post('/login', [LoginController::class, 'login'])
                ->middleware(['throttle:3,1']);
        });

        Route::group([
            'middleware' => 'auth:sanctum'
        ], function () {
            Route::post('/register-verify', [RegisterController::class, 'registerVerify']);
            Route::post('/resend-verification', [RegisterController::class, 'resendVerification'])
                ->middleware(['captcha']);
        });

        Route::group([
            'prefix' => 'password'
        ], function () {

            Route::post('/forget', [ForgetedPasswordController::class, 'passwordForget'])->middleware(['throttle:5,1'])
                ->middleware(['captcha']);
            Route::post('/update', [ForgetedPasswordController::class, 'passwordUpdate'])
                ->middleware(['captcha']);

        });
    });

    Route::group([
        'prefix' => 'me',
        'middleware' => ['auth:sanctum']
    ], function () {

        Route::get('/', [MeController::class, 'me']);
        Route::get('/roles', [MeController::class, 'roles']);

    });

    Route::group([
        'prefix' => 'app'
    ], function () {

        Route::get('/layers', [ApplicationController::class, 'layers']);
        Route::get('/roles', [ApplicationController::class, 'roles']);
        Route::get('/permissions/{layer}', [ApplicationController::class, 'permissions']);

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
            Route::patch('/{user}/promote/{role}', [UsersController::class, 'promote']);
            Route::patch('/{user}/demote/{role}', [UsersController::class, 'demote']);
            Route::delete('/{user}/delete', [UsersController::class, 'destroy']);

        });

        Route::group([
            'prefix' => 'roles'
        ], function () {

            Route::get('/', [RolesController::class, 'index']);
            Route::post('/create', [RolesController::class, 'store']);
            Route::get('/{role}/show', [RolesController::class, 'show']);
            Route::put('/{role}/update', [RolesController::class, 'update']);
            Route::patch('/{role}/give-permission/{permission}', [RolesController::class, 'givePermission']);
            Route::patch('/{role}/revoke-permission/{permission}', [RolesController::class, 'revokePermission']);
            Route::delete('/{role}/delete', [RolesController::class, 'destroy']);

        });

    });

});
