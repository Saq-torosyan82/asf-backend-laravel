<?php

/**
 * @apiGroup           Communication
 * @apiName            FindCommunicationById
 *
 * @api                {GET} /v1/communications/:id Find Communication by ID
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": {
        "id": "XbPW7awNLkGl83LD",
        "title": "test",
        "type": 2,
        "type_label": "service center",
        "question_type": "Information",
        "created_at": "05.04.2022 02:36 PM (GMT)",
        "participants": [
            {
                "user_id": 80,
                "is_admin": true,
                "full_name": "SportsFI",
                "avatar": ""
            },…
        ],
        "deal": [],
        "last_activity": "01.01.1970 12:00 AM (GMT)"
        },
        "meta": {
            "include": [],
            "custom": []
        }
    }
}
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('communications/{id}', [Controller::class, 'findById'])
    ->name('api_communication_find_communication_by_id')
    ->middleware(['auth:api']);

