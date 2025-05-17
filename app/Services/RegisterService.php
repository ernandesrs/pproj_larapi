<?php

namespace App\Services;

use App\Enums\TokenCheckEnum;
use App\Models\TokenCheck;

class RegisterService
{
    /**
     * Verify
     * @param array $validated
     * @return bool
     */
    public static function verify(array $validated): bool
    {
        $checkToken = TokenCheck::where('token', $validated['hash'])
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
}
