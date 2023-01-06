<?php

namespace App\Containers\AppSection\Deal\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ContractAlreadySignedException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'contract already signed';
}
