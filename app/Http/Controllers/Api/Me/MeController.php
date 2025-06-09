<?php

namespace App\Http\Controllers\Api\Me;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\UserService;
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
     * Me update
     * @param \App\Http\Requests\UserUpdateRequest $userUpdateRequest
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $userUpdateRequest): JsonResponse
    {
        return UserService::update(\Auth::user(), $userUpdateRequest->validated()) ?
            ApiResponse::success() :
            ApiResponse::response([], 500);
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
                    return [
                        'name' => $role->name,
                        'admin_access' => $role->admin_access,
                        'permissions' => $role->permissions()->get()
                            ->map(fn(Permission $permission) => $permission->name)
                    ];
                })
        ]);
    }
}
