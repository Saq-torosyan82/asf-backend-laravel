<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            deleteUserSponsorshipAgent
 *
 * @api                {DELETE} /v1/me/athletes/:userid/sponsorships/:sponsorshipid Delete user Sponsorship Agent
 * @apiDescription     Delete user Sponsorship Agent
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is Athlete, Agent
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

Route::delete('me/athletes/{userId}/sponsorships/{sponsorshipId}', [Controller::class, 'deleteUserSponsorshipAgent'])
    ->name('api_usersponsorship_delete_user_sponsorship_agent')
    ->middleware(['auth:api']);

