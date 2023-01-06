<?php

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class PasswordsDoesntMatchException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = "the two passwords doesn't match";
}
