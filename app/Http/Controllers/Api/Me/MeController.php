<?php

namespace App\Http\Controllers\Api\Me;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    /**
     * Get me
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return ApiResponse::success([
            'me' => \Auth::user()
        ]);
    }
}
