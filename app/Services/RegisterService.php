<?php

namespace App\Services;

use App\Enums\TokenCheckEnum;
use App\Models\TokenCheck;
use App\Models\User;

class RegisterService
{
    /**
     * Verify
     * @param array $validated
     * @return bool
     */
    public static function verify(array $validated): bool
    {
        $checkToken = TokenCheck::where('token', $validated['token'])
            ->where('token_to', TokenCheckEnum::REGISTER_VERIFICATION)
            ->first();

        if (!$checkToken)
            return false;

        $user = $checkToken->user()->first();
        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            $checkToken->delete();
        }

        return true;
    }

    /**
     * Send verification link to user
     * @param \App\Models\User $user
     * @return bool
     */
    public static function sendVerification(User $user): bool
    {
        // delete old
        $oldTokenCheck = $user->tokensCheck()->first();
        if ($oldTokenCheck) {
            $oldTokenCheck->delete();
        }

        // create new
        $tokenCheck = $user->generateTokenToRegisterVerification();
        if ($tokenCheck) {
            \Mail::to($user)->queue(
                new \App\Mail\RegisterVerificationMail($user, $tokenCheck)
            );

            return true;
        }

        return false;
    }
}
