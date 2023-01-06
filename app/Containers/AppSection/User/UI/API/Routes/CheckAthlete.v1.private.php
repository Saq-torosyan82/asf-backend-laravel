<?php

/**
 * @apiGroup           User
 * @apiName            checkAthlete
 *
 * @api                {POST} /v1/users/check-athlete Check is user is athlete
 * @apiDescription     Check is user is athlete
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  first_name Athlete First name
 * @apiParam           {String}  last_name Athlete Last name
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  []
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('users/check-athlete', [Controller::class, 'checkAthlete'])
    ->name('api_user_check_athlete')
    ->middleware(['auth:api']);

