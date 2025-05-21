<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // dd(\App\Models\Permission::getDefinedPermissions(
    //     \App\Enums\AppLayer::CUSTOMER
    // ));
    return view('welcome');
});

/**
 *
 *
 * DEV
 *
 *
 */
Route::get('/mailable', function () {
    $user = \App\Models\User::first();
    $check = \App\Models\TokenCheck::make([
        'token_to' => \App\Enums\TokenCheckEnum::REGISTER_VERIFICATION,
        'token' => \Str::upper(\Str::random(5))
    ]);
    return new App\Mail\RegisterVerificationMail($user, $check);
});
