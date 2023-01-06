<?php

/**
 * @apiGroup           Deal
 * @apiName
 *
 * @api                {GET} /v1/ Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('export-deals/{id}', [Controller::class, 'exportDealDetail'])
    ->name('api_deal_export_deal')
    ->middleware(['auth:api']);

