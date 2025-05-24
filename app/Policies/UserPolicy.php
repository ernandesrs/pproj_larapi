<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends BasePolicy
{
    /**
     * Update
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function update(User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        if (!parent::update($user, $model) || $user->id === $model->id)
            return false;

        return $user->isSuperuser() ? true : !$model->isAdmin();
    }

    /**
     * Update
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function delete(User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        if (!parent::delete($user, $model) || $user->id === $model->id)
            return false;

        return $user->isSuperuser() ? true : !$model->isAdmin();
    }

    /**
     * Promote user
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function promote(User $user, User $model): bool
    {
        if ($user->id === $model->id)
            return false;

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
        if ($user->id === $model->id)
            return false;

        return $user->isSuperuser();
    }
}
