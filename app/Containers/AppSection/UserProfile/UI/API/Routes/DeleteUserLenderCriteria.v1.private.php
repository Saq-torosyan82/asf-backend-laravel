<?php

/**
 * @apiGroup           UserProfile
 * @apiName            DeleteUserLenderCriteria
 *
 * @api                {DELETE} /v1/users/:user_id/lender-criteria/:lender_criteria_id Delete user lender deal criteria
 * @apiDescription     Delete user lender deal criteria
 *
 * @apiVersion         1.0.0
 * @apiPermission      Admin
 *
 * @apiParam           {String}  user_id
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

Route::delete('users/{user_id}/lender-criteria/{lender_deal_criteria_id}', [Controller::class, 'DeleteUserLenderDealCriteria'])
    ->name('api_userprofile_delete_user_lender_criteria')
    ->middleware(['auth:api']);

