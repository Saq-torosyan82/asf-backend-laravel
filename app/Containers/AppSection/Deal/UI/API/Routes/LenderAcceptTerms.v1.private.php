<?php

/**
 * @apiGroup           Deal
 * @apiName            LenderAcceptTerms
 *
 * @api                {POST} /v1/lender-terms Lender accept deal terms
 * @apiDescription     Lender accept deal terms
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  deal_id Deal id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('lender-terms', [Controller::class, 'LenderAcceptTerms'])
    ->name('api_deal_lender_accept_terms')
    ->middleware(['auth:api']);

