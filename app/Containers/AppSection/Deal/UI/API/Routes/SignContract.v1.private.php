<?php

/**
 * @apiGroup           Deal
 * @apiName            SignContract
 *
 * @api                {POST} /v1/deals/:id/sign-contract Sign Contract
 * @apiDescription     Sign Contract
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Deal id
 * @apiParam           {String}  status
 * @apiParam           {String}  signature
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    no content
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deals/{id}/sign-contract', [Controller::class, 'SignContract'])
    ->name('api_deal_change_deal_status')
    ->middleware(['auth:api']);

