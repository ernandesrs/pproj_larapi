<?php

namespace App\Policies;

use App\Enums\RolesEnum;

class RolePolicy extends BasePolicy
{
    /**
     * Update
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function update(\App\Models\User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        // Default roles cannot be edited
        if (collect(RolesEnum::cases())->map(fn($role) => $role->value)->contains($model->name)) {
            return false;
        }
        return parent::update($user, $model);
    }

    /**
     * Update role permissions
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function updateRolePermissions(\App\Models\User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        if ($model->name === RolesEnum::SUPERUSER->value) {
            return false;
        }
        return parent::update($user, $model);
    }

    /**
     * Delete
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function delete(\App\Models\User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        // Default roles cannot be edited
        if (collect(RolesEnum::cases())->map(fn($role) => $role->value)->contains($model->name)) {
            return false;
        }

        return parent::delete($user, $model);
    }
}
