<?php

/**
 * @apiGroup           System
 * @apiName            GetAllSportClubs
 *
 * @api                {GET} /v1/system/sport-clubs Get all sport clubs
 * @apiDescription     Get all sport clubs
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
        "league_id": "",
        "country_id": "",
        "sport_id": "",
        "name": "",
        "logo": ""
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

Route::get('system/sport-clubs', [Controller::class, 'GetAllSportClubs'])
    ->name('api_system_get_all_sport_clubs')
    ->middleware(['auth:api']);
