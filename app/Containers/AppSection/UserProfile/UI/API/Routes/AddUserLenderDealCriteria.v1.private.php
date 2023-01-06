<?php

/**
 * @apiGroup           UserProfile
 * @apiName            AddUserLenderDealCriteria
 *
 * @api                {POST} /v1/users/:user_id/lender-criteria Add user lender criteria
 * @apiDescription     Add user lender criteria
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  user_id User id
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
    data: {
        id: ''
    }
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('users/{user_id}/lender-criteria', [Controller::class, 'AddUserLenderDealCriteria'])
    ->name('api_userprofile_add_user_lender_deal_criteria')
    ->middleware(['auth:api']);

