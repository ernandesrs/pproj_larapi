<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetedPasswordUpdateRequest;
use App\Http\Requests\PasswordForgetRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgetedPasswordController extends Controller
{
    /**
     * Password Forget
     * @param \App\Http\Requests\PasswordForgetRequest $request
     * @return JsonResponse
     */
    public function passwordForget(PasswordForgetRequest $request): JsonResponse
    {
        return UserService::passwordForget(
            $request->validated()
        ) ? ApiResponse::success() : ApiResponse::response([], 500);
    }

    /**
     * Password update
     * @param \App\Http\Requests\ForgetedPasswordUpdateRequest $request
     * @return JsonResponse
     */
    public function passwordUpdate(ForgetedPasswordUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->firstOrFail();
        return UserService::passwordUpdate(
            $user,
            $request->validated(),
            true
        ) ? ApiResponse::success() : ApiResponse::response([], 500);
    }
}
