<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    protected $message = 'Bad request error.';
}
