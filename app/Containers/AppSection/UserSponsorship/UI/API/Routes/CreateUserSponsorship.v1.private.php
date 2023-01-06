<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            CreateUserSponsorship
 *
 * @api                {POST} /v1/users/{userId}/sponsorships Create user sponsorship
 * @apiDescription     Create user sponsorship
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is agent or agency or athlete or admin
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

Route::post('users/{userId}/sponsorships', [Controller::class, 'createUserSponsorship'])
    ->name('api_usersponsorship_create_user_sponsorship')
    ->middleware(['auth:api']);

