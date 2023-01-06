<?php

/**
 * @apiGroup           MySponsorship
 * @apiName            deleteMySponsorship
 *
 * @api                {DELETE} /v1/me/sponsorships/:sponsorshipid/ Delete Sponsorship
 * @apiDescription     Delete Sponsorship
 *
 * @apiVersion         1.0.0
 * @apiPermission      User id athlete or corporate
 *
 * @apiParam           {String}  id Sposnor id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\UserSponsorship\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('me/sponsorships/{id}', [Controller::class, 'deleteMySponsorship'])
    ->name('api_usersponsorship_delete_my_sponsorship')
    ->middleware(['auth:api']);

