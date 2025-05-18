<?php

namespace App\Exceptions\Api;

use App\Traits\ApiExceptionTrait;
use Exception;

class InvalidLoginCredentialsException extends Exception
{
    use ApiExceptionTrait;

    /**
     * Code
     * @return int
     */
    public function code(): int
    {
        return 401;
    }

    /**
     * Message
     * @return string
     */
    public function message(): string
    {
        return "Invalid login credentials.";
    }
}
