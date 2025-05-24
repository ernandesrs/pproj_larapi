<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Get all registered roles
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::success([
            'items' => RoleResource::collection(
                Role::limit(15)->get()
            )
        ]);
    }

    /**
     * Store a new role
     * @param \App\Http\Requests\Admin\RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        \Gate::authorize('create', Role::class);
        return ApiResponse::success([
            'role' => new RoleResource(
                RoleService::create($request->validated())
            )
        ]);
    }

    /**
     * Show a role
     * @param \App\Models\Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        \Gate::authorize('view', $role);
        return ApiResponse::success([
            'role' => new RoleResource($role)
        ]);
    }

    /**
     * Update role data
     * @param \App\Http\Requests\Admin\RoleRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        \Gate::authorize('update', $role);
        $status = RoleService::update($role, $request->validated()) ? 200 : 500;
        return ApiResponse::response([
            'role' => new RoleResource($status == 200 ? $role->fresh() : $role)
        ], $status);
    }

    /**
     * Give permission to a role
     * @param \App\Models\Role $role
     * @param \App\Models\Permission $permission
     * @return JsonResponse
     */
    public function givePermission(Role $role, Permission $permission): JsonResponse
    {
        \Gate::authorize('updateRolePermissions', $role);
        return ApiResponse::response([], RoleService::givePermission($role, $permission) ? 200 : 500);
    }

    /**
     * Revoke a permission from a role
     * @param \App\Models\Role $role
     * @param \App\Models\Permission $permission
     * @return JsonResponse
     */
    public function revokePermission(Role $role, Permission $permission): JsonResponse
    {
        \Gate::authorize('updateRolePermissions', $role);
        return ApiResponse::response([], RoleService::revokePermission($role, $permission) ? 200 : 500);
    }

    /**
     * Destroy a role
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        \Gate::authorize('delete', $role);
        return ApiResponse::response(
            [],
            RoleService::delete($role) ? 200 : 500
        );
    }
}
