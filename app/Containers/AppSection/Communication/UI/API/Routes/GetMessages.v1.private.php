<?php

/**
 * @apiGroup           Communication
 * @apiName            Get Messages
 *
 * @api                {GET} /v1/communications/messages/:com_id Get Messages
 * @apiDescription     Get all messages of communication
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": [
        {
            "id": "76qxErGXQ2yXP3lV",
            "is_read": 0,
            "last_activity": "06.04.2022 12:32 PM (GMT)",
            "message_body": "hi",
            "sent_date": "06. Apr 2022, 12:32 PM (GMT)",
            "attachements": [
                {
                    "download_url": "http://api.asf.test/v1/download/499eaa7a-6e71-4323-b59a-a63e04524074",
                    "file_path": "communications/46/240_F_1649248374.jpg",
                    "id": 296,
                    "init_file_name": "240_F.jpg",
                    "uuid": "499eaa7a-6e71-4323-b59a-a63e04524074",
                },…
            ],
            "recievers": [
                {
                    "avatar": "",
                    "full_name": "SportsFi",
                    "id": "80"
                }
            ],
            "sender": {
                avatar: ""
                full_name: "Nume CinciDoi"
                id: 46
            }
        },
    ]
}
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('communications/messages/{com_id}', [Controller::class, 'getMessages'])
    ->name('api_communication_get_messages')
    ->middleware(['auth:api']);

