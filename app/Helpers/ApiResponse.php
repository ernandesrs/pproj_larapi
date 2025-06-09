<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Response
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response(array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => $status === 200,
            ...$data
        ], $status);
    }

    /**
     * Success
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(array $data = []): JsonResponse
    {
        return static::response($data, 200);
    }

    /**
     * Unauthorized
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized(array $data = []): JsonResponse
    {
        return static::response($data, 401);
    }

    /**
     * Invalidated
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function invalidated(array $data = []): JsonResponse
    {
        return static::response($data, 422);
    }

    /**
     * Internal Error
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function internalError(array $data = []): JsonResponse
    {
        return static::response($data, 500);
    }
}
