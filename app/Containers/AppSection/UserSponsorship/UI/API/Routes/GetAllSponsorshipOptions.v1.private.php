<?php

/**
 * @apiGroup           UserSponsorship
 * @apiName            getAllSponsorshipOptions
 *
 * @api                {GET} /v1/sponsorships Get all sponsorship options
 * @apiDescription     Get all sponsorship options
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
    "id": "NxOpZowo9GmjKqdR",
    "name": "Yokohama",
    "type": "sponsor"
    },
    {
    "id": "XbPW7awNkzl83LD6",
    "name": "Chevrolet",
    "type": "sponsor"
    },
    ...
]
 */

use App\Containers\AppSection\UserSponsorship\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('sponsorships', [Controller::class, 'getAllSponsorshipOptions'])
    ->name('api_usersponsorship_get_all_sponsorship_options')
    ->middleware(['auth:api']);

