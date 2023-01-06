<?php

/**
 * @apiGroup           System
 * @apiName            GetAllSportLeagues
 *
 * @api                {GET} /v1/system/sport-leagues Get all sport leagues
 * @apiDescription     Get all sport leagues
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 *
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

Route::get('system/sport-leagues', [Controller::class, 'GetAllSportLeagues'])
    ->name('api_system_get_all_sport_leagues')
    ->middleware(['auth:api']);
