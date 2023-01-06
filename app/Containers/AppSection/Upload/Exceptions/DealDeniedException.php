<?php

namespace App\Containers\AppSection\Upload\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DealDeniedException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'access denied to deal';
}
