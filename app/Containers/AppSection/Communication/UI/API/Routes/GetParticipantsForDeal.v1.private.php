<?php

/**
 * @apiGroup           Communication
 * @apiName           getParticipantsForDeal
 *
 * @api                {GET} /v1/participants/:deal_id? Get All Participants
 * @apiDescription     When the `deal_id` is sent, then returned all participants of the deal, otherwise returned only admin's corresponding data.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
[
    {
        "id": "DxrnX3z9JmGBReV4",
        "first_name": "SportsFi",
        "last_name": "Admin",
        "is_admin": true
    },
    {
        "id": "XbPW7awNLkGl83LD",
        "first_name": "Nume",
        "last_name": "CinciDoi",
        "is_admin": true
    }
]
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('communications/participants/{deal_id?}', [Controller::class, 'getParticipantsForDeal'])
    ->name('api_get_participants_for_deal')
    ->middleware(['auth:api']);



