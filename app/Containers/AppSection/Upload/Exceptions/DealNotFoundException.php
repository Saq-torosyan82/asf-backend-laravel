<?php

namespace App\Containers\AppSection\Upload\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DealNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;
    protected $message = 'deal not found';
}
