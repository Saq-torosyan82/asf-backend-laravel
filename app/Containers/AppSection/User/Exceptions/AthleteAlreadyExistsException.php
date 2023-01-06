<?php

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class AthleteAlreadyExistsException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'there is an athelete with the same first name and last name';
}
