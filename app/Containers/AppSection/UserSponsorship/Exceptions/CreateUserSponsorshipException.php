<?php

namespace App\Containers\AppSection\UserSponsorship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class CreateUserSponsorshipException extends Exception
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $message = 'Exception Default Message.';
}
