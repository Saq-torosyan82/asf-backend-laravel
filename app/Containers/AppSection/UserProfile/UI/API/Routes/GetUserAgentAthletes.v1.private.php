<?php

/**
 * @apiGroup           UserProfile
 * @apiName            GetUserAgentAthletes
 *
 * @api                {GET} /v1/users/:user_id/athletes Get user agent athletes
 * @apiDescription     Get user agent athletes
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is admin
 *
 * @apiParam           {String}  user_id
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

Route::get('users/{user_id}/athletes', [Controller::class, 'GetUserAgentAthletes'])
    ->name('api_userprofile_get_user_agent_athletes')
    ->middleware(['auth:api']);

