<?php

/**
 * @apiGroup           Deal
 * @apiName            MySuccessRate
 *
 * @api                {GET} /v1/me/success-rate Get lender success rate
 * @apiDescription    Get lender success rate
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data: {
    nb_terms '',
    nb_live_deals '',
    success_rate '',
    }
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/success-rate', [Controller::class, 'MySuccessRate'])
    ->name('api_deal_my_success_rate')
    ->middleware(['auth:api']);

