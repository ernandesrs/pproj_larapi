<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Login
     * @param \App\Http\Requests\LoginRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $appName = $request->header('X-From-AppName');
        $validated = $request->validated();

        $attemptResponse = \Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ], $validated['remember']);

        if (!$attemptResponse) {
            return response(status: 401);
        }

        $oldTokens = \Auth::user()->tokens()->where('name', $appName)->get();
        if ($oldTokens->count()) {
            $oldTokens->map(fn($token) => $token->delete());
        }

        return response()->json([
            'auth_token' => \Auth::user()->createToken($appName)->plainTextToken
        ]);
    }
}
