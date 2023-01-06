<?php

/**
 * @apiGroup           UserProfile
 * @apiName            UpdateLenderDealCriteria
 *
 * @api                {PUT} /v1/me/lender-criteria/:lender_deal_criteria_id Update lender deal criteria
 * @apiDescription     Update lender deal criteria
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is lender
 *
 * @apiParam           {String}  lender_deal_criteria_id
 * @apiParam           {String}  country Country id
 * @apiParam           {String}  currency
 * @apiParam           {String}  min_amount
 * @apiParam           {String}  min_amount.id
 * @apiParam           {String}  max_amount
 * @apiParam           {String}  max_amount.id
 * @apiParam           {String}  min_tenor
 * @apiParam           {String}  min_tenor.id
 * @apiParam           {String}  max_tenor
 * @apiParam           {String}  max_tenor.id
 * @apiParam           {String}  min_interest_rate
 * @apiParam           {String}  min_interest_rate.id
 * @apiParam           {String}  interest_range
 * @apiParam           {String}  interest_range.id
 * @apiParam           {String}  type
 * @apiParam           {String}  type.id
 * @apiParam           {String}  note
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::put('me/lender-criteria/{lender_deal_criteria_id}', [Controller::class, 'UpdateLenderDealCriteria'])
    ->name('api_userprofile_update_lender_deal_criteria')
    ->middleware(['auth:api']);

