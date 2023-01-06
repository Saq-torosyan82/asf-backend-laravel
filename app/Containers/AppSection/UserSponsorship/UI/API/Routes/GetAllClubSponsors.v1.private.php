<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            getAllClubSponsors
 *
 * @api                {GET} /v1/club-sponsors Get club sponsors
 * @apiDescription     Get club sponsors
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "sponsors": [
    {
    "id": "NREkYV2vr523ae1y",
    "logo": "http://api.apiato.test/storage/logo/sport-sponsors/1&1.png",
    "name": "1&1"
    },
    {
    "id": "KJqn4Z26EBGdlv6M",
    "logo": "http://api.apiato.test/storage/logo/default/league.png",
    "name": "11Teamsports"
    },
    {
    "id": "doa7DZzEqWzJ5PYQ",
    "logo": "http://api.apiato.test/storage/logo/default/league.png",
    "name": "12 Bet"
    },
    ...
    ],
    "types": {
    "shirt": "Shirt sponsor",
    "sleeve": "Sleeve sponsor",
    "kit": "Kit sponsor",
    "main_partner": "Main sponsor"
    }
}
 */

use App\Containers\AppSection\UserSponsorship\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('club-sponsors', [Controller::class, 'getClubSponsors'])
    ->name('api_usersponsorship_get_all_club_sponsors')
    ->middleware(['auth:api']);

