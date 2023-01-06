<?php

/**
 * @apiGroup           System
 * @apiName            CreateSportSponsor
 *
 * @api                {POST} /v1/system/sport-sponsors Create sport sponsor
 * @apiDescription     Create sport sponsor
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, isBorrower
 *
 * @apiParam           {String}  name Sponsor name
 * @apiParam           {File}    logo Sponsor logo
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    id: '',
    name: ''
    logo: ''
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('/system/sport-sponsors', [Controller::class, 'CreateSportSponsor'])
    ->name('api_system_create_sport_sponsor')
    ->middleware(['auth:api']);

