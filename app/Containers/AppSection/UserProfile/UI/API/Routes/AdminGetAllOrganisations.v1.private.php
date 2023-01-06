<?php

/**
 * @apiGroup           UserProfile
 * @apiName            getAllAgents
 *
 * @api                {GET} /v1/admin/organisations Get all organisations
 * @apiDescription     Get all organisations
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
    "id": "VxZM0Jzb8P2Xrpdk",
    "users": [],
    "name": "First37 Last37",
    "avatar": ""
    },
    {
    "id": "0QvXO3GJ3B2kxAqY",
    "users": [],
    "name": "First38 Last38",
    "avatar": ""
    },
   ...
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('admin/organisations', [Controller::class, 'getAllOrganisations'])
    ->name('api_userprofile_admin_get_all_organisations')
    ->middleware(['auth:api']);

