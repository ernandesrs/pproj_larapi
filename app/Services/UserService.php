<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService implements ServiceInterface
{
    /**
     * Create a new resource
     * @param array $validated
     * @return ?User
     */
    public static function create(array $validated, bool $sendVerification = false): ?User
    {
        $user = User::create($validated);

        if ($user && $sendVerification) {
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
        if (empty(isset($validated["password"]))) {
            unset($validated['password']);
        } else {
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
     * Promote
     * @param \App\Models\User $user
     * @param \App\Models\Role $role
     * @return bool
     */
    public static function promote(User $user, Role $role): bool
    {
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }
        return true;
    }

    /**
     * Demote
     * @param \App\Models\User $user
     * @param \App\Models\Role $role
     * @return bool
     */
    public static function demote(User $user, Role $role): bool
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
        }
        return true;
    }

    /**
     * Delete a resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public static function delete(Model $model): bool
    {
        return $model->delete();
    }
}
