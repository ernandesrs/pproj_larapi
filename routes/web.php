<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/verify', function (\Illuminate\Http\Request $request) {
    $validated = \Validator::make([
        'hash' => $request->get('hash'),
    ], [
        'hash' => ['nullable', 'string']
    ])->validate();

    if (!$validated['hash']) {
        echo "Verification hash not found";
        return false;
    }

    echo "Verified!";

    return true;
})->name('auth.verify');

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
