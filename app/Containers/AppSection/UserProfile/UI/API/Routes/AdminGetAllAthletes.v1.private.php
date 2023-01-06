<?php

/**
 * @apiGroup           UserProfile
 * @apiName            getAllAthletes
 *
 * @api                {GET} /v1/admin/athletes Get all athletes
 * @apiDescription     Get all athletes
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiParam           {String}  [btid] Borrower id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
    "id": "8p6aY5zx7w9P3keO",
    "name": "Nicolae Casir",
    "avatar": "",
    "club": "Mjällby AIF"
    },
    {
    "id": "jM7L5PzYaPzOJdrl",
    "name": "fasdfas dfasdfasd",
    "avatar": "",
    "club": "SK Rapid Wien"
    },
    {
    "id": "NxOpZowo99GmjKqd",
    "name": "Test CinciDoi",
    "avatar": "http://api.apiato.test/v1/download/b8855fa0-280e-4d8a-ae7e-9152f129fb4b",
    "club": "Shenzhen"
    },
    {
    "id": "aYOxlpzRZjzrX3gD",
    "name": "First34 Last34",
    "avatar": "",
    "club": ""
    },
    ...
]
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('admin/athletes', [Controller::class, 'getAllAthletes'])
    ->name('api_userprofile_admin_get_all_athletes')
    ->middleware(['auth:api']);

