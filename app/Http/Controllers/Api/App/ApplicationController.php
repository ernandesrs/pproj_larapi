<?php

namespace App\Http\Controllers\Api\App;

use App\Enums\ApplicationLayers;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Get all defined application layers
     * @return JsonResponse
     */
    public function layers(): JsonResponse
    {
        return ApiResponse::success([
            'layers' => collect(ApplicationLayers::cases())->map(fn($ApplicationLayers) => $ApplicationLayers->value)
        ]);
    }

    /**
     * Get all registered application roles
     * @return JsonResponse
     */
    public function roles(): JsonResponse
    {
        return ApiResponse::success([
            'roles' => Role::all()->map(function (Role $role) {
                $permissions = $role->name == \App\Enums\RoleEnum::SUPERUSER->value ?
                    Permission::all(['name']) :
                    $role->permissions()->get(['name']);
                return [
                    'name' => $role->name,
                    'permissions' => $permissions->map(fn($permission) => $permission->name)
                ];
            })
        ]);
    }

    /**
     * Get all defined application permissions
     * @return JsonResponse
     */
    public function permissions(string $layer): JsonResponse
    {
        $layer = collect(ApplicationLayers::cases())->first(fn($applicationLayers) => $applicationLayers->value == $layer);
        return $layer ?
            ApiResponse::success([
                'permissions' => Permission::getDefinedPermissions($layer)
            ]) :
            ApiResponse::invalidated([
                'error' => 'InvalidLayer',
                'message' => 'The provided layer name is invalid.'
            ]);
    }
}
