<?php

/**
 * @apiGroup           Deal
 * @apiName            ChangeDealStatus
 *
 * @api                {PATCH} /v1/deals/:id/status Change Deal status
 * @apiDescription     Change Deal status
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String} id Deal id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  No Content
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('deals/{id}/status', [Controller::class, 'ChangeDealStatus'])
    ->name('api_deal_change_deal_status')
    ->middleware(['auth:api']);

