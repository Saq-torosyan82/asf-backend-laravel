<?php

/**
 * @apiGroup           System
 * @apiName            CreateSportClub
 *
 * @api                {POST} /v1/system/sport-clubs Create sport club
 * @apiDescription     Create a sport club
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, isBorrower
 *
 * @apiParam           {String}  name Club name
 * @apiParam           {String}  league_id League id
 * @apiParam           {String}  country_id Country id
 * @apiParam           {File}    [logo] Club logo
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  id: '',
  league_id: '',
  country_id: '',
  sport_id: '',
  name: '',
 logo: ''

}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('/system/sport-clubs', [Controller::class, 'CreateSportClub'])
    ->name('api_system_create_sport_club')
    ->middleware(['auth:api']);

