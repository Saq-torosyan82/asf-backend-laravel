<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            getAllUserSponsorshipsAgent
 *
 * @api                {GET} /v1/me/athletes/:userid/sponsorships/ Get all user sponsorships Agent.
 * @apiDescription     Get all user sponsorships Agent.
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  userId
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
    "id": "KJqn4Z261BGdlv6M",
    "type": "shirt",
    "logo": "http://api.apiato.test/storage/logo/default/deal.png",
    "name": "11Teamsports"
    },
    {
    "id": "AKxY1RwjRWwEN40r",
    "type": "sleeve",
    "logo": "",
    "name": ""
    },
    {
    "id": "XOKlq3GKK6GA1PWJ",
    "type": "kit",
    "logo": "http://api.apiato.test/storage/logo/default/deal.png",
    "name": "188BET"
    },
    {
    "id": "0QvXO3GJ3B2kxAqY",
    "type": "main_partner",
    "logo": "http://api.apiato.test/storage/logo/club-sponsors/deutsche-telekom.png",
    "name": "Deutsche Telekom"
    },
    {
    "id": "NxOpZowo4ZzmjKqd",
    "type": "main_partner",
    "logo": "http://api.apiato.test/storage/logo/default/deal.png",
    "name": "AccorHotels"
    },
    {
    "id": "doa7DZzELAwJ5PYQ",
    "type": "main_partner",
    "logo": "http://api.apiato.test/storage/logo/default/deal.png",
    "name": "12 Bet"
    }
]
 */

use App\Containers\AppSection\UserSponsorship\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/athletes/{userId}/sponsorships/', [Controller::class, 'getAllUserSponsorshipsAgent'])
    ->name('api_usersponsorship_get_all_user_sponsorships_agent')
    ->middleware(['auth:api']);

