<?php

/**
 * @apiGroup           User
 * @apiName            CheckPasswordSet
 *
 * @api                {GET} /v1/me/have-password-set Check if password is set
 * @apiDescription     Check if password is set
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    empty_password: true or false
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/have-password-set', [Controller::class, 'CheckPasswordSet'])
    ->name('api_user_check_password_set')
    ->middleware(['auth:api']);

