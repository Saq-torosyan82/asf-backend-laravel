<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ConflictException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'Conflict error.';
}
