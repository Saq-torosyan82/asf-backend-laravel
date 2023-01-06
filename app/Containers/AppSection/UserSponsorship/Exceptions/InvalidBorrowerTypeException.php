<?php

namespace App\Containers\AppSection\UserSponsorship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidBorrowerTypeException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'Invalid borrower type';
}
