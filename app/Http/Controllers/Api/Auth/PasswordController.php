<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordForgetRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordController extends Controller
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
}
