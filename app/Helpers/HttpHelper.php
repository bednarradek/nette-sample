<?php

namespace App\Helpers;

class HttpHelper
{
    public const
        HTTP_STATUS_OK = 200,
        HTTP_STATUS_BAD_REQUEST = 400,
        HTTP_STATUS_UNAUTHORIZED = 401,
        HTTP_STATUS_METHOD_NOT_ALLOWED = 405;

    public const
        HTTP_METHOD_GET = 'GET',
        HTTP_METHOD_POST = 'POST';
}