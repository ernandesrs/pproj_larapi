<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    /**
     * Login
     * @param array $validated
     * @return User|null
     */
    public static function login(array $validated): ?User
    {
        $authResponse = \Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ], $validated['remember']);

        if (!$authResponse) {
            return null;
        }

        return \Auth::user();
    }

    /**
     * Get auth token
     * @param string $tokenName
     * @return string
     */
    public static function getAuthToken(string $tokenName = 'default'): string
    {
        $oldAuthTokens = \Auth::user()->tokens()->where('name', $tokenName)->get();
        if ($oldAuthTokens->count()) {
            $oldAuthTokens->map(fn($token) => $token->delete());
        }
        return 'Bearer ' . \Auth::user()->createToken($tokenName)->plainTextToken;
    }
}
