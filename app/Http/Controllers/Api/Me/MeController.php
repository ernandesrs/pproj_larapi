<?php

namespace App\Http\Controllers\Api\Me;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    /**
     * Get me
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return ApiResponse::success([
            'me' => \Auth::user()
        ]);
    }

    /**
     * Get all authenticated user roles
     * @return JsonResponse
     */
    public function roles(): JsonResponse
    {
        return ApiResponse::success([
            'roles' => \Auth::user()->roles()->get()
                ->map(function (Role $role) {
                    $permissions = $role->name == \App\Enums\RoleEnum::SUPERUSER->value ?
                        Permission::all() :
                        $role->permissions()->get();
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'permissions' => $permissions->map(fn(Permission $permission) => [
                            'id' => $permission->id,
                            'name' => $permission->name
                        ])
                    ];
                })
        ]);
    }
}
