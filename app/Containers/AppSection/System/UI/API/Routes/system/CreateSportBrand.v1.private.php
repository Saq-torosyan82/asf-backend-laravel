<?php

/**
 * @apiGroup           System
 * @apiName            CreateSportBrand
 *
 * @api                {POST} /v1/system/sport-brands Create sport brand
 * @apiDescription     Create a sport brand
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, isBorrower
 *
 * @apiParam           {String}  name Sport brand name
 * @apiParam           {File}   logo Sport brand Logo
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  id: '',
  name: '',
  logo: '',
}
 */

use App\Containers\AppSection\System\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('/system/sport-brands', [Controller::class, 'CreateSportBrand'])
    ->name('api_system_create_sport_brand')
    ->middleware(['auth:api']);

