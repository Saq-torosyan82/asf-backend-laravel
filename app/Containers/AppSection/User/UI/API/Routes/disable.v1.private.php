<?php

/**
 * @apiGroup           User
 * @apiName            disableAccount
 *
 * @api                {GET} /v1/me/disable Disable account
 * @apiDescription     Disable account
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, Owner of account
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/disable', [Controller::class, 'disableAccount'])
    ->name('api_user_disable_account')
    ->middleware(['auth:api']);

