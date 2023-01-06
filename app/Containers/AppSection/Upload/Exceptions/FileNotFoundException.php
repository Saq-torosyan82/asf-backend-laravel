<?php

namespace App\Containers\AppSection\Upload\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class FileNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;
    protected $message = 'could not find the requested file';
}
