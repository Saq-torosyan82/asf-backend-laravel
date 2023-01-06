<?php

namespace App\Containers\AppSection\Deal\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ConflictOfferStatusException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'invalid offer status';
}
