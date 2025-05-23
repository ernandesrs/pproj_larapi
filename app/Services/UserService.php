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
            RegisterService::sendVerification($user);
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
        if (isset($validated["password"])) {
            $validated["password"] = \Hash::make($validated["password"]);
        }

        return $model->update($validated);
    }

    /**
     * Password forget: send message with recovery code
     * @param array $validated
     * @return bool
     */
    public static function passwordForget(array $validated): bool
    {
        $oldForgetCode = \DB::table('password_reset_tokens')
            ->where('email', $validated['email']);
        if ($oldForgetCode->count()) {
            $createdAt = \Illuminate\Support\Carbon::parse($oldForgetCode->first()->created_at);
            throw_if(
                $createdAt->addMinutes(5) >= now(),
                new \App\Exceptions\Api\ManyAttemptsException("An email has already been sent. Please wait or try again in a few minutes.")
            );

            $oldForgetCode->delete();
        }

        $user = User::where('email', $validated['email'])->firstOrFail(['id', 'email']);
        $code = \Str::upper(\Str::random(5));
        $forgetCode = \DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $code,
            'created_at' => now()
        ]);
        if ($forgetCode) {
            \Mail::to($user)
                ->queue(new \App\Mail\PasswordForgetMail($user, $code));

            return true;
        }

        return false;
    }

    /**
     * Password update
     * @param array $validated
     * @return bool
     */
    public static function passwordUpdate(User $user, array $validated, bool $forgeted = false): bool
    {
        if ($forgeted) {
            \DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->where('token', $validated['code'])->delete();
        }

        return $user->update([
            'password' => \Hash::make($validated['password'])
        ]);
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
