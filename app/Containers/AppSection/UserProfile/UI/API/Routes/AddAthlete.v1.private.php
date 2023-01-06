<?php

/**
 * @apiGroup           UserProfile
 * @apiName            AddAthlete
 *
 * @api                {POST} /v1/me/athletes Add athlete
 * @apiDescription     Add athlete
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, is Agent
 *
 * @apiParam           {String}  account.first_name
 * @apiParam           {String}  account.last_name
 * @apiParam           {String}  account.email
 * @apiParam           {String}  address.country
 * @apiParam           {String}  address.street
 * @apiParam           {String}  [address.state]
 * @apiParam           {String}  address.city
 * @apiParam           {String}  [address.zip]
 * @apiParam           {String}  professional.sport
 * @apiParam           {String}  professional.country
 * @apiParam           {String}  professional.league
 * @apiParam           {String}  professional.club
 * @apiParam           {String}  contact.phone
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('me/athletes', [Controller::class, 'AddAthlete'])
    ->name('api_userprofile_add_athlete')
    ->middleware(['auth:api']);

