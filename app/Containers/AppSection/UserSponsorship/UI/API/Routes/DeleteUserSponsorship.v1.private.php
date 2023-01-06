<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            deleteUserSponsorship
 *
 * @api                {DELETE} /v1/users/{userId}/sponsorships/:sponsorshipid/ Delete user Sponsorship
 * @apiDescription     Delete user Sponsorship
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is Athlet,Agent,Agency, Or Admin
 *
 * @apiParam           {String}  userId
 * @apiParam           {String}  sponsorshipId
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserSponsorship\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('/users/{userId}/sponsorships/{sponsorshipId}', [Controller::class, 'deleteUserSponsorship'])
    ->name('api_usersponsorship_delete_user_sponsorship')
    ->middleware(['auth:api']);

