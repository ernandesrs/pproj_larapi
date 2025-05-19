<?php

namespace App\Exceptions\Api;

use App\Traits\ApiExceptionTrait;
use Exception;

class ManyAttemptsException extends Exception
{
    use ApiExceptionTrait;

    /**
     * Code
     * @return int
     */
    public function code(): int
    {
        // 429 Too Many Requests (RFC 6585)
        return 429;
    }

    public function message(): string
    {
        return "Many attempts in a short time, wait.";
    }
}
