<?php

/**
 * @apiGroup           Communication
 * @apiName            getAllCommunications
 *
 * @api                {GET} /v1/communications Get All Communications
 * @apiDescription     Get all communications of an authenticated user
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": [
        {
            "id": "7VgmkMw7R2pWO5ja",
            "title": "test",
            "type": 1,
            "type_label": "deals",
            "question_type": "",
            "created_at": "06.04.2022 12:40 PM (GMT)",
            "last_activity": "22.04.2022 06:07 AM (GMT)",
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
            "deal": {
                "id": "7YmnlQzpVb2gDRrv",
                "type": "player_transfer",
                "type_label": "Player transfer",
                "status": "not_started",
                "status_label": "Not started",…
            }
        },…
    ],
    "meta": {
        "include": [],
        "custom": []
    }
}
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('communications', [Controller::class, 'getAll'])
    ->name('api_communication_get_all_communications')
    ->middleware(['auth:api']);

