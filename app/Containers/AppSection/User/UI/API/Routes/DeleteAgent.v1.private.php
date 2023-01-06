<?php

/**
 * @apiGroup           User
 * @apiName            id
 *
 * @api                {DELETE} /v1/me/agents/id Delete agent
 * @apiDescription     Delete agent
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, the user is agent
 *
 * @apiParam           {String}  id Agent id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('me/agents/{id}', [Controller::class, 'deleteAgent'])
    ->name('api_user_delete_agent')
    ->middleware(['auth:api']);

