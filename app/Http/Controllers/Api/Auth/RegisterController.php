<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Api\EmailHasAlreadyBeenVerifiedException;
use App\Exceptions\Api\InvalidTokenException;
use App\Exceptions\Api\ManyAttemptsException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Services\AuthService;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Store user account
     * @param \App\Http\Requests\UserRegisterRequest $request
     * @return JsonResponse
     */
    public function store(UserRegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = RegisterService::register($validated);

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
     * @exception \App\Exceptions\Api\InvalidTokenException
     */
    public function registerVerify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['nullable', 'string']
        ]);

        throw_if(empty($validated['code']), InvalidTokenException::class);

        return RegisterService::verify($validated) ?
            ApiResponse::success() :
            ApiResponse::unauthorized();
    }

    /**
     * Resend verification link
     * @return JsonResponse
     * @exception \App\Exceptions\Api\EmailHasAlreadyBeenVerifiedException
     * @exception \App\Exceptions\Api\ManyAttemptsException
     */
    public function resendVerification(): JsonResponse
    {
        $user = \Auth::user();

        throw_if($user->email_verified_at != null, EmailHasAlreadyBeenVerifiedException::class);

        $tokenCheck = $user->tokensCheck()->first();
        if ($tokenCheck) {
            /**
             * @var \Illuminate\Support\Carbon
             */
            $createdAt = $tokenCheck->created_at;
            throw_if($createdAt->addMinutes(5) >= \Illuminate\Support\Carbon::now(), new ManyAttemptsException("Email has already been sent! Wait or try in a few minutes."));
        }

        return RegisterService::sendVerification($user) ? ApiResponse::success() : ApiResponse::response(status: 500);
    }
}
