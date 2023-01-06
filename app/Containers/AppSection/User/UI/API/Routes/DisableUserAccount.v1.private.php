<?php

/**
 * @apiGroup           User
 * @apiName            disableUserAccount
 *
 * @api                {DELETE} /v1/users/:id/disable Disable user account
 * @apiDescription     Disable user account
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id User id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('users/{id}/disable', [Controller::class, 'disableUserAccount'])
    ->name('api_user_disable_user_account')
    ->middleware(['auth:api']);

