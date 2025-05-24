<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class RoleService implements ServiceInterface
{
    /**
     * Create
     * @param array $validated
     * @return null
     */
    public static function create(array $validated): Model|null
    {
        return Role::create($validated);
    }

    /**
     * Update
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $validated
     * @return bool
     */
    public static function update(Model $model, array $validated): bool
    {
        return $model->update($validated);
    }

    /**
     * Give permission
     * @param \App\Models\Role $role
     * @param \App\Models\Permission $permission
     * @return bool
     */
    public static function givePermission(Role $role, Permission $permission): bool
    {
        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
        return true;
    }

    /**
     * Revoke permission
     * @param \App\Models\Role $role
     * @param \App\Models\Permission $permission
     * @return bool
     */
    public static function revokePermission(Role $role, Permission $permission): bool
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
        }
        return true;
    }

    /**
     * Delete
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public static function delete(Model $model): bool
    {
        return $model->delete();
    }
}
