<?php

/**
 * @apiGroup           MySponsorship
 * @apiName            CreateMySponsorship
 *
 * @api                {POST} /v1/me/sponsorships Create sponsorship
 * @apiDescription     Create sponsorship
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is borrower and corporate or athlete
 *
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

Route::post('me/sponsorships', [Controller::class, 'createMySponsorship'])
    ->name('api_usersponsorship_create_user_sponsorship')
    ->middleware(['auth:api']);

