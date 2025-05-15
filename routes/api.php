<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'success' => true
    ]);
});

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('/register', [RegisterController::class, 'store'])->name('auth.register');

});
