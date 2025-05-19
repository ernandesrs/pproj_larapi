<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Api\InvalidLoginCredentialsException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Login
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $authUser = AuthService::login($validated);
        throw_if(!$authUser, new InvalidLoginCredentialsException());

        return ApiResponse::success([
            'auth_token' => AuthService::getAuthToken($validated['token_name'])
        ]);
    }
}
