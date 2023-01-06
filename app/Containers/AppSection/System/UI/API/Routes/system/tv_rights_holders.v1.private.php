<?php

/**
 * @apiGroup           System
 * @apiName            GetAllTvRightsHolders
 *
 * @api                {GET} /v1/systems/tv-rights-holders Get all TV rights holders
 * @apiDescription     Get all TV rights holders
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
    "logo": "
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

Route::get('system/tv-rights-holders', [Controller::class, 'GetAllTvRightsHolders'])
    ->name('api_system_get_all_tv_rights_holders')
    ->middleware(['auth:api']);
