<?php

namespace App\Containers\AppSection\UserProfile\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class HasNoAccessException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'has no access';
}
