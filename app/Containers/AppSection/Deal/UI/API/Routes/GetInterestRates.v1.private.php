<?php

/**
 * @apiGroup           Deal
 * @apiName            GetInterestRates
 *
 * @api                {GET} /v1/interest-rates/:type/:entity_id Get interest rates
 * @apiDescription     Patch offer
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  type Entity type
 * @apiParam           {String}  entity_id Entity id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('interest-rates/{type}/{entity_id}', [Controller::class, 'getInterestRates'])
    ->name('api_deal_get_interest_rates')
    ->middleware(['auth:api']);

