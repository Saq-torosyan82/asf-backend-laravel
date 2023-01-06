<?php

/**
 * @apiGroup           Communication
 * @apiName            createCommunication
 *
 * @api                {POST} /v1/communications/deal  Create Communication
 * @apiDescription     This endpoint is used to create new `deal` type communication. We can create new service type communication using `service` instead of `deal`. The parameters`deal_id` and `participant_id` are required for creating deal type communication. For service type communication `participant_id` automatically corresponds to the admin's ID. The parameter `question_type` is required only for creating service type communication.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String}  title   Communication title
 * @apiParam           {String}  deal_id Deal ID
 * @apiParam           {Number}  question_type Question type key
 * @apiParam           {String}  participant_id Participant ID
 * @apiParam           {String}  message_body   Message body
 * @apiParam           {Array}  attachements  This is an array of attachments ID's, which is generated when file/files uploaded
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": {
        "id": "YJ5evQ20ywx68dKl",
        "created_at": "22.04.2022 07:24 AM (GMT)",
        "question_type": "",
        "title": "test",
        "type": 1,
        "type_label": "deals",
        "deal": {
            "id": "RVmdrKwBlXG5Q7Ob",
            "type": "player_transfer",
            "type_label": "Player transfer",
            "status": "not_started",…
        }
        "participants": [
            {
                "user_id": 46,
                "is_admin": false,
                "full_name": "Nume CinciDoi",
                "avatar": {
                    "headers": {},
                    "original": "F5sXsnavW3bimoOmDMBB8xZO0g0WlIWPYt8RKVGVGw...",
                    "exception": null
                }
            },…
        ],
    }
    "meta": {
        "include": [],
        "custom": []
    }
}
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('communications/deal', [Controller::class, 'createDealType'])
    ->name('api_communication_create_deal_communication')
    ->middleware(['auth:api']);

Route::post('communications/service', [Controller::class, 'createServiceType'])
    ->name('api_communication_create_service_communication')
    ->middleware(['auth:api']);

