<?php

/**
 * @apiGroup           User
 * @apiName            checkEmailAvailability
 *
 * @api                {POST} /v1/users/check-email-availability cCheck email availability
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  email Email
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  []
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('users/check-email-availability', [Controller::class, 'checkEmailAvailability'])
    ->name('api_user_check_email_availability')
    ->middleware(['auth:api']);

