<?php

namespace App\Traits;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

trait ApiExceptionTrait
{
    /**
     * Message
     * @return string
     */
    abstract public function message(): string;

    /**
     * Code
     * @return int
     */
    abstract public function code(): int;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): JsonResponse
    {
        $response = [
            "error" => str_replace("Exception", "", class_basename($this)),
            "message" => $this->message(),
        ];

        if ($errors = session()->get("validation_errors", null)) {
            $response += [
                'validation_errors' => $errors
            ];
        }

        return ApiResponse::response($response, $this->code());
    }
}
