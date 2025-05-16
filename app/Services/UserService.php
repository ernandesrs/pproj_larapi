<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService implements ServiceInterface
{
    /**
     * Create a new resource
     * @param array $validated
     * @return ?User
     */
    public static function create(array $validated): ?User
    {
        $user = User::create($validated);

        if ($user) {
            $tokenCheck = $user->generateTokenToRegisterVerification();

            \Mail::to($user)->queue(
                new \App\Mail\RegisterVerificationMail($user, $tokenCheck)
            );

            return $user;
        }

        return null;
    }

    /**
     * Update a resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $validated
     * @return bool
     */
    public static function update(Model $model, array $validated): bool
    {
        return false;
    }

    /**
     * Delete a resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public static function delete(Model $model): bool
    {
        return false;
    }
}
