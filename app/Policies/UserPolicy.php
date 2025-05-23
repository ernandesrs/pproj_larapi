<?php

namespace App\Policies;

use App\Enums\Permissions\Admin\UserPermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends BasePolicy
{
    /**
     * Admin Access
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function adminAccess(User $user, User $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::ADMIN_ACCESS->value
        );
    }

    /**
     * Promote user
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function promote(User $user, User $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::PROMOTE_USER->value
        );
    }

    /**
     * Demote user
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function demote(User $user, User $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::DEMOTE_USER->value
        );
    }
}
