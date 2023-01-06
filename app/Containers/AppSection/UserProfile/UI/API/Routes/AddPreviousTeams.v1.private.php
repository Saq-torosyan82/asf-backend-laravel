<?php

/**
 * @apiGroup           UserProfile
 * @apiName            AddPreviousTeams
 *
 * @api                {POST} /v1/previous-teams/ Add previous teams
 * @apiDescription     Add previous teams
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess. User is agent or Athlete
 *
 * @apiParam           {String}  user_id User id
 * @apiParam           {Array}  teams  Array keys are : country (country id) , league (league id), team (team id), leagues (array), clubs (array)
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('previous-teams/', [Controller::class, 'AddPreviousTeams'])
    ->name('api_userprofile_add_previous_teams')
    ->middleware(['auth:api']);

