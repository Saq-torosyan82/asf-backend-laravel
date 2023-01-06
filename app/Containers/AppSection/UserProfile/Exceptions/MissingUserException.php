<?php

namespace App\Containers\AppSection\UserProfile\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class MissingUserException extends Exception
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $message = 'missing user id';
}
