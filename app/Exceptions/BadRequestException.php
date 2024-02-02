<?php

namespace App\Exceptions;

use App\Helpers\HttpHelper;
use RuntimeException;

class BadRequestException extends RuntimeException
{
    public function __construct(string $message = "Bad request")
    {
        parent::__construct($message, HttpHelper::HTTP_STATUS_BAD_REQUEST);
    }
}
