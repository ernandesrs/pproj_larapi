<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegisterRequest $request)
    {
        dd($request->all());
    }
}
