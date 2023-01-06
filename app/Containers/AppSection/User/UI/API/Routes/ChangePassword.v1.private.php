<?php

/**
 * @apiGroup           User
 * @apiName            ChangePassword
 *
 * @api                {POST} /v1/password/change Change Password
 * @apiDescription     Change Password
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  old_password
 * @apiParam           {String}  password
 * @apiParam           {String}  password_confirmation
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    no content
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('password/change', [Controller::class, 'ChangePassword'])
    ->name('api_user_change_password')
    ->middleware(['auth:api']);

