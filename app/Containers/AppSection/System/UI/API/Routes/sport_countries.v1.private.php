<?php

/**
 * @apiGroup           System
 * @apiName            GetAllSportCountries
 *
 * @api                {GET} /v1/system/sport-countries Get all sport countries
 * @apiDescription     Get all sport countries
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String} sport id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
 [
    {
       id: '',
       name: ''
    }
 ]
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('system/sport-countries/{sport_id}', [Controller::class, 'GetAllSportCountries'])
    ->name('api_system_get_all_sport_countries')
    ->middleware(['auth:api']);
