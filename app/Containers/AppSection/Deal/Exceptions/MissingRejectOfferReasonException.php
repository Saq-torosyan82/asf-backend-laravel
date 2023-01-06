<?php

namespace App\Containers\AppSection\Deal\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class MissingRejectOfferReasonException extends Exception
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $message = 'missing reject reason';
}
