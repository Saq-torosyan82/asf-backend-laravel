<?php

/**
 * @apiGroup           System
 * @apiName            GetAllSportBrands
 *
 * @api                {GET} /v1/system/sport-brands Get all sport brands
 * @apiDescription     Get all sport brands
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
        "id": "NxOpZowo9GmjKqdR",
        "name": "Nike",
        "logo": "http://api.apiato.test/storage/logo/sport-brands/nike.png"
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

Route::get('system/sport-brands', [Controller::class, 'GetAllSportBrands'])
    ->name('api_system_get_all_sport_brands')
    ->middleware(['auth:api']);
