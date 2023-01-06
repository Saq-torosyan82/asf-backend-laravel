<?php

namespace App\Containers\AppSection\Deal\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ForbiddenOfferStatusException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'you are not allowed to change deal status';
}
