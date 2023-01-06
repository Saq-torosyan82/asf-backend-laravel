<?php

namespace App\Containers\AppSection\UserSponsorship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UserSponsorshipExistsException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'Sponsorship already is assigned to the borrower';
}
