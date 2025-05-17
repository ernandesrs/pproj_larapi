<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/verify', [RegisterController::class, 'verify'])
    ->name('auth.verify');

/**
 *
 *
 * DEV
 *
 *
 */
Route::get('/mailable', function () {
    $user = \App\Models\User::first();
    // return new App\Mail\RegisterVerificationMail($user);
});
