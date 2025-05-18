<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Api\InvalidLoginCredentialsException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
        $appName = $request->header('X-From-AppName');
        $validated = $request->validated();

        if (
            !\Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password']
            ], $validated['remember'])
        ) {
            throw new InvalidLoginCredentialsException();
        }

        $oldTokens = \Auth::user()->tokens()->where('name', $appName)->get();
        if ($oldTokens->count()) {
            $oldTokens->map(fn($token) => $token->delete());
        }

        return ApiResponse::success([
            'auth_token' => \Auth::user()->createToken($appName)->plainTextToken
        ]);
    }
}
