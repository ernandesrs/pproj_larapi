<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\RoleService;
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
    public function store(RoleRequest $request)
    {
        \Gate::authorize('create', Role::class);
        return ApiResponse::success([
            'role' => new RoleResource(
                RoleService::create($request->validated())
            )
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
