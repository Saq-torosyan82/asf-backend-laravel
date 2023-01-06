<?php

/**
 * @apiGroup           Deal
 * @apiName            MyDeals
 *
 * @api                {GET} /v1/me/deals-summary Get summary deals
 * @apiDescription     Get summary deals
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *s
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

Route::get('me/deals-summary', [Controller::class, 'MyDeals'])
    ->name('api_deal_my_deals')
    ->middleware(['auth:api']);

