<?php

/**
 * @apiGroup           UserProfile
 * @apiName            DeleteAthlete
 *
 * @api                {DELETE} /v1/me/athletes/:user_id Delete athlete
 * @apiDescription     Delete athlete
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is agent
 *
 * @apiParam           {String}  user_id Athlete id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('me/athletes/{user_id}', [Controller::class, 'DeleteAthlete'])
    ->name('api_userprofile_delete_athlete')
    ->middleware(['auth:api']);

