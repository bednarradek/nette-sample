<?php

namespace App\Exceptions;

use App\Helpers\HttpHelper;
use RuntimeException;

class UnauthorizedException extends RuntimeException
{
    public function __construct(string $message = "Unauthorized", int $code = HttpHelper::HTTP_STATUS_UNAUTHORIZED)
    {
        parent::__construct($message, $code);
    }
}
