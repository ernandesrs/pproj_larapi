<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Services\RegisterService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function verify(Request $request): Response
    {
        $validated = $request->validate([
            'hash' => ['required', 'string']
        ]);

        $response = RegisterService::verify($validated);

        return response($response ? 'Verified!' : 'Verification failed!');
    }
}
