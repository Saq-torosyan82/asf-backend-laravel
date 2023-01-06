<?php

/**
 * @apiGroup           System
 * @apiName            GetAllSportSponsors
 *
 * @api                {GET} /v1/system/sport-sponsors Get all sport sponsors
 * @apiDescription     Get all sport sponsors
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
        "sport_id": "",
        "name": "",
        "level": "",
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

Route::get('system/sport-sponsors', [Controller::class, 'GetAllSportSponsors'])
    ->name('api_system_get_all_sport_sponsors')
    ->middleware(['auth:api']);
