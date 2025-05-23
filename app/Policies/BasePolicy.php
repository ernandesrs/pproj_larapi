<?php

namespace App\Policies;

use App\Enums\Permissions\Admin\UserPermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
    /**
     * Check if user can view any current models
     * @param \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::VIEW_ANY->value
        );
    }

    /**
     * Check if user can view on model
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function view(User $user, Model $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::VIEW->value
        );
    }

    /**
     * Check if user can create a new model
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::CREATE->value
        );
    }

    /**
     * Check if user can update current model
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function update(User $user, Model $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::UPDATE->value
        );
    }

    /**
     * Check if user can delete current model
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function delete(User $user, Model $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::DELETE->value
        );
    }

    /**
     * Check if user can delete many current model
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function deleteMany(User $user, Model $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::DELETE_MANY->value
        );
    }

    /**
     * Check if user can restore current model
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function restore(User $user, Model $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::RESTORE->value
        );
    }

    /**
     * Check if user can force delete current model
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function forceDelete(User $user, Model $model): bool
    {
        return $user->isSuperuser() || $user->hasPermissionTo(
            UserPermissionEnum::FORCE_DELETE->value
        );
    }
}
