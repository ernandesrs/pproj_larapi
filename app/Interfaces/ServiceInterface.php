<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    /**
     * Create a new resource
     * @param array $validated
     * @return ?Model
     */
    public static function create(array $validated): ?Model;

    /**
     * Update a resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $validated
     * @return bool
     */
    public static function update(Model $model, array $validated): bool;

    /**
     * Delete a resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public static function delete(Model $model): bool;
}
