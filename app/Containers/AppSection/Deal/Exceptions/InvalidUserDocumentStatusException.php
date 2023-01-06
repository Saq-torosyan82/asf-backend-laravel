<?php

namespace App\Containers\AppSection\Deal\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidUserDocumentStatusException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'invalid user document status';
}
