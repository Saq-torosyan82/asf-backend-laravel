<?php

namespace App\Containers\AppSection\Deal\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class BorrowerDidntSignedContractException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'borrower did not signed contract';
}
