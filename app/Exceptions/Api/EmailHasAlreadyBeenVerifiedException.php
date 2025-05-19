<?php

namespace App\Exceptions\Api;

use App\Traits\ApiExceptionTrait;
use Exception;

class EmailHasAlreadyBeenVerifiedException extends Exception
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
        return "Your email has already been verified.";
    }
}
