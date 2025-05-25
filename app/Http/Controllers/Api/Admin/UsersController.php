<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Get users
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        \Gate::authorize('viewAny', User::class);

        return ApiResponse::success([
            'items' => UserResource::collection(
                User::limit(15)->get()
            )
        ]);
    }

    /**
     * Store a new user
     * @param \App\Http\Requests\Admin\UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        \Gate::authorize('create', User::class);
        $createdUser = UserService::create($request->validated());
        return ApiResponse::success([
            'user' => $createdUser ? new UserResource($createdUser) : null
        ]);
    }

    /**
     * Get a user data
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        \Gate::authorize('view', $user);
        return ApiResponse::success([
            'user' => new UserResource($user),
            'roles' => RoleResource::collection(Role::all())
        ]);
    }

    /**
     * Update a user
     * @param \App\Http\Requests\Admin\UserRequest $request
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        \Gate::authorize('update', $user);
        return ApiResponse::response(
            [],
            UserService::update($user, $request->validated()) ? 200 : 500
        );
    }

    /**
     * Destroy a user
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        \Gate::authorize('delete', $user);
        return ApiResponse::response([], UserService::delete($user) ? 200 : 500);
    }

    /**
     * Promote a user
     * @param \App\Models\User $user
     * @param \App\Models\Role $role
     * @return JsonResponse
     */
    public function promote(User $user, Role $role): JsonResponse
    {
        \Gate::authorize('promote', $user);
        UserService::promote($user, $role);
        return ApiResponse::success();
    }

    /**
     * Demote a user
     * @param \App\Models\User $user
     * @param \App\Models\Role $role
     * @return JsonResponse
     */
    public function demote(User $user, Role $role): JsonResponse
    {
        \Gate::authorize('demote', $user);
        UserService::demote($user, $role);
        return ApiResponse::success();
    }
}
