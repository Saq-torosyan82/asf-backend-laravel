<?php

/**
 * @apiGroup           UserProfile
 * @apiName            DeleteLenderCriteria
 *
 * @api                {DELETE} /v1/me/lender-criteria/:lender_criteria_id Delete lender criteria
 * @apiDescription     Delete lender criteria
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is Lender
 *
 * @apiParam           {String}  lender_deal_criteria_id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('me/lender-criteria/{lender_deal_criteria_id}', [Controller::class, 'DeleteLenderDealCriteria'])
    ->name('api_userprofile_delete_lender_criteria')
    ->middleware(['auth:api']);

