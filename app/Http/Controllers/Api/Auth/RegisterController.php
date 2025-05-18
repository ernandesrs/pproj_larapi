<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Services\RegisterService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegisterRequest $request): JsonResponse
    {
        $user = UserService::create($request->validated());
        return ApiResponse::success([
            'data' => $user
        ]);
    }

    /**
     * Verify account
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['nullable', 'string']
        ]);

        throw_if(empty($validated['token']), \App\Exceptions\Api\InvalidTokenException::class);

        return RegisterService::verify($validated) ?
            ApiResponse::success() :
            ApiResponse::unauthorized();
    }
}
