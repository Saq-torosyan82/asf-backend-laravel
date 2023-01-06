<?php

/**
 * @apiGroup           Deal
 * @apiName            PatchOffer
 *
 * @api                {PATCH} /v1/deals/:id/offers/:offer_id Patch offer
 * @apiDescription     Patch offer
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Deals Id
 * @apiParam           {String}  offer_id Offer id
 * @apiParam           {String}  status The status
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('deals/{id}/offers/{offer_id}/', [Controller::class, 'patchOffer'])
    ->name('api_deal_patch_offer')
    ->middleware(['auth:api']);

