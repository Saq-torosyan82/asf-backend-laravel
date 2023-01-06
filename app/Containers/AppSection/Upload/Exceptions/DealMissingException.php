<?php

namespace App\Containers\AppSection\Upload\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DealMissingException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'missing deal id';
}
