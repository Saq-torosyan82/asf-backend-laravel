<?php

/**
 * @apiGroup           System
 * @apiName            GetAllClubCountries
 *
 * @api                {GET} /v1/system/club-countries Get all club countries
 * @apiDescription     Get all club countries
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
            "id": "XbPW7awNkzl83LD6",
            "name": "Albania"
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

Route::get('system/club-countries', [Controller::class, 'GetAllClubCountries'])
    ->name('api_system_get_all_club_countries')
    ->middleware(['auth:api']);
