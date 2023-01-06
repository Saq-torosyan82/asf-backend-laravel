<?php

/**
 * @apiGroup           Authentication
 * @apiName            ValidateLoginToken
 *
 * @api                {POST} /v1/validate-login-token Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

use App\Containers\AppSection\Authentication\UI\API\Controllers\Controller;
use App\Containers\AppSection\Authentication\UI\API\Controllers\AutoLoginController;
use Illuminate\Support\Facades\Route;

Route::post('validate-login-token', [AutoLoginController::class, 'ValidateLoginToken'])
    ->name('api_authentication_validate_login_token');

