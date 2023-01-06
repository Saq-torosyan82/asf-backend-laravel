<?php

/**
 * @apiGroup           System
 * @apiName            CreateSportLeague
 *
 * @api                {POST} /v1/system/sport-leagues Create leagues
 * @apiDescription     Create league
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, isBorrower
 *
 * @apiParam           {String}  name League name
 * @apiParam           {File}    [logo] League logo
 * @apiParam           {File}    [association_logo] Association logo
 * @apiParam           {File}    [confederation_logo] Confederation logo
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  id: '',
  sport_id: ''
  name: ''
  level: ''
  logo: ''
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('/system/sport-leagues', [Controller::class, 'CreateSportLeagues'])
    ->name('api_system_create_sport_leagues')
    ->middleware(['auth:api']);

