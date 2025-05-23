<?php

namespace App\Exceptions\Api;

use App\Traits\ApiExceptionTrait;
use Exception;

class ForbiddenException extends Exception
{
    use ApiExceptionTrait;

    /**
     * Code
     * @return int
     */
    public function code(): int
    {
        return 403;
    }

    /**
     * Message
     * @return string
     */
    public function message(): string
    {
        return "Action or access forbidden!";
    }
}
