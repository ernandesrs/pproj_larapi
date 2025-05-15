<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    (new \Database\Seeders\RoleAndPermissionSeeder())->run();
    return view('welcome');
});
