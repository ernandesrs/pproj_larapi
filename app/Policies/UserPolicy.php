<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends BasePolicy
{
    /**
     * Promote user
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function promote(User $user, User $model): bool
    {
        return $user->isSuperuser();
    }

    /**
     * Demote user
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function demote(User $user, User $model): bool
    {
        return $user->isSuperuser();
    }
}
