<?php

namespace App\Exceptions\Api;

use App\Traits\ApiExceptionTrait;
use Exception;

class InvalidTokenException extends Exception
{
    use ApiExceptionTrait;

    /**
     * Code
     * @return int
     */
    public function code(): int
    {
        return 422;
    }

    /**
     * Message
     * @return string
     */
    public function message(): string
    {
        return "The provided token is invalid.";
    }
}
