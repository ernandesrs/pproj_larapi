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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
