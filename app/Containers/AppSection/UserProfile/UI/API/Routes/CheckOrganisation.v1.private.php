<?php

/**
 * @apiGroup           UserProfile
 * @apiName            CheckOrganisation
 *
 * @api                {POST} /v1/users/check-organisation Check if organisation exists
 * @apiDescription     Check if organisation exists
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Organisation id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    organisation_exists: true or false
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('users/check-organisation', [Controller::class, 'CheckOrganisation'])
    ->name('api_userprofile_check_organisation')
    ->middleware(['auth:api']);

