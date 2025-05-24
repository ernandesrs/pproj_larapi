<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
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
        return false;
    }

    /**
     * Delete
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public static function delete(Model $model): bool
    {
        return false;
    }
}
