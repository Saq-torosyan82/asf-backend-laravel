<?php

namespace App\Containers\AppSection\UserSponsorship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UserUniqueSponsorshipExistsException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'Sponsorship with this type is already assigned to the borrower';
}
