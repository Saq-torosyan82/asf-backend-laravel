<?php

/**
 * @apiGroup           Deal
 * @apiName            GetUserDeals
 *
 * @api                {GET} /v1/me/athletes/:user_id/deals Get user deals
 * @apiDescription    Get user (athletes) deals by id
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String} user_id User id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data: [
    {
        id: '',
        deal_type: '',
        contract_type: '',
        status: '',
        status_label': '',
        reason: '',
        reason_label: '',
        contract_amount: '',
        currency: '',
        deal_amount: 'ß',
        funding_date: ''
    }
 * ...
 ]
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/athletes/{user_id}/deals-summary', [Controller::class, 'GetUserDeals'])
    ->name('api_deal_get_user_deals')
    ->middleware(['auth:api']);

