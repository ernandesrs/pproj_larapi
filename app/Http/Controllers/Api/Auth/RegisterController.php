<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Services\AuthService;
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
        $validated = $request->validated();
        $user = UserService::create($validated);

        AuthService::login([
            'email' => $user->email,
            'password' => $validated['password'],
            'remember' => false
        ]);

        return ApiResponse::success([
            'auth_token' => AuthService::getAuthToken($validated['token_name']),
            'data' => $user
        ]);
    }

    /**
     * Register verify
     * @return JsonResponse
     */
    public function registerVerify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['nullable', 'string']
        ]);

        throw_if(empty($validated['code']), \App\Exceptions\Api\InvalidTokenException::class);

        return RegisterService::verify($validated) ?
            ApiResponse::success() :
            ApiResponse::unauthorized();
    }

    /**
     * Resend verification link
     * @return JsonResponse
     */
    public function resendVerification(): JsonResponse
    {
        $user = \Auth::user();

        throw_if($user->email_verified_at != null, \App\Exceptions\Api\EmailHasAlreadyBeenVerifiedException::class);

        $tokenCheck = $user->tokensCheck()->first();
        if ($tokenCheck) {
            /**
             * @var \Illuminate\Support\Carbon
             */
            $createdAt = $tokenCheck->created_at;
            throw_if($createdAt->addMinutes(5) >= \Illuminate\Support\Carbon::now(), new \App\Exceptions\Api\ManyAttemptsException("Email has already been sent! Wait or try in a few minutes."));
        }

        return RegisterService::sendVerification($user) ? ApiResponse::success() : ApiResponse::response(status: 401);
    }
}
