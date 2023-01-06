<?php

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidResetTokenException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = "missing or expired token";
}
