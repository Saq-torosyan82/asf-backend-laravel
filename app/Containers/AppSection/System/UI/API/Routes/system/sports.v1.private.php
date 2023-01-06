<?php

/**
 * @apiGroup           System
 * @apiName            GetAllSports
 *
 * @api                {GET} /v1/system/sports Get all sports list
 * @apiDescription     Get all active sports list
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": [
        {
        "id": "",
        "name": "",
        "has_country": true,
        "has_league": true,
        "has_club": true,
        },
        ...
    ],
    "meta": {
    "include": [],
    "custom": []
    }
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('system/sports', [Controller::class, 'getAllSports'])
    ->name('api_system_get_all_sports')
    ->middleware(['auth:api']);
