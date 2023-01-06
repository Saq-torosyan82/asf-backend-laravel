<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            CreateUserSponsorshipAgent
 *
 * @api                {POST} /v1/me/athletes/:userid/sponsorships/ Create user sponsorship agent
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is Athlete or agent
 *
 * @apiParam           {String}  userId
 * @apiParam           {String}  id Sponsor id
 * @apiParam           {String}  type Sponsor type
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserSponsorship\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('me/athletes/{userId}/sponsorships/', [Controller::class, 'createUserSponsorshipAgent'])
    ->name('api_usersponsorship_create_user_sponsorship_agent')
    ->middleware(['auth:api']);

