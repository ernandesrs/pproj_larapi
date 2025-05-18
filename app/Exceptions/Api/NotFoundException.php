<?php

namespace App\Exceptions\Api;

use App\Traits\ApiExceptionTrait;
use Exception;

class NotFoundException extends Exception
{
    use ApiExceptionTrait;

    /**
     * Code
     * @return int
     */
    public function code(): int
    {
        return 404;
    }

    /**
     * Message
     * @return string
     */
    public function message(): string
    {
        return "Resource not found.";
    }
}
