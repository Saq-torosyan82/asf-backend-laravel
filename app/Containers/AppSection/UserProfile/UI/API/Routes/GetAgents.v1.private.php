<?php

/**
 * @apiGroup           UserProfile
 * @apiName            getAgents
 *
 * @api                {GET} /v1/me/agents Get agents
 * @apiDescription     Get agents
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is agency
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
    id: '',
    first_name: '',
    last_name: '',
    phone: '',
    avatar: ''
    }
     * ....
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/agents', [Controller::class, 'getAgents'])
    ->name('api_userprofile_get_agents')
    ->middleware(['auth:api']);

