<?php

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class EmailAlreadyUsedException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'email already used';
}
