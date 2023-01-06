<?php

/**
 * @apiGroup           User
 * @apiName            MagicLink
 *
 * @api                {POST} /v1/magic-link Send Magic link to login user
 * @apiDescription     Send Magic link to login user
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  email Account email
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('magic-link', [Controller::class, 'MagicLink'])
    ->name('api_user_magic_link');
