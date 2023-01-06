<?php

/**
 * @apiGroup           Deal
 * @apiName            SubmitDeal
 *
 * @api                {POST} /v1/deal/:id/submit Update deal
 * @apiDescription     Update deal
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Deal id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data: {
        id: ''
     }
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deals/update', [Controller::class, 'UpdateDeal'])
    ->name('api_deals_update_deal')
    ->middleware(['auth:api']);

