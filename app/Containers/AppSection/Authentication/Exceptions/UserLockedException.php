<?php

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UserLockedException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    protected $message = 'This account is locked for authentication';
}
