<?php

/**
 * @apiGroup           UserProfile
 * @apiName            GetAgentAthletes
 *
 * @api                {GET} /v1/me/athletes Get agent athletes
 * @apiDescription     Get agent athletes
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is agent
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
   {
        id: '',
       name: '',
       club: '',
       avatar: '',
       agent_name: ''
  }
 * ....
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/athletes', [Controller::class, 'GetAgentAthletes'])
    ->name('api_userprofile_get_agent_athletes')
    ->middleware(['auth:api']);

