<?php

namespace App\Containers\AppSection\Notification\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidEntityException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = "invalid notification entity";
}
