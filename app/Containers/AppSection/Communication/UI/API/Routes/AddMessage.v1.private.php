<?php

/**
 * @apiGroup           Communication
 * @apiName            addMessage
 *
 * @api                {POST} /v1/communications/message/:com_id Add Message
 * @apiDescription     Add a new message to communication
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String}  message_body Message body
 * @apiParam           {Array}  attachements  This is an array of attachments ID's, which is generated when file/files uploaded
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "data": {
        "id": "doa7DZzEdOwJ5PYQ",
        "message_body": "New Message 11212",
        "sent_date": "22. Apr 2022, 06:05 AM (GMT)",
        "last_activity": "22.04.2022 06:05 AM (GMT)",
        "is_read": 0,
        "recievers": [
            {
                "id": "80",
                "full_name": "SportsFi",
                "avatar": ""
            },…
        ],
        "attachements": [
            {
                "download_url": "http://api.asf.test/v1/download/ba2cfef5-a8ac-4097-af3e-252a4b7a68b2"
                "file_path": "communications/46/image_1_1650607454.png"
                "id": 300
                "init_file_name": "image_1.png"
                "uuid": "ba2cfef5-a8ac-4097-af3e-252a4b7a68b2"
            },…
        ],
        "sender": {
            "id": 46,
            "full_name": "Nume CinciDoi",
            "avatar": {
                "headers": {},
                "original": "F5sXsnavW3bimoOmDMBB8xZO0g0WlIWPYt8RKVGVGw...",
                "exception": null
            }
        }
    },
    "meta": {
        "include": [],
        "custom": []
    }
}
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('communications/message/{com_id}', [Controller::class, 'addMessage'])
    ->name('api_communication_add_message')
    ->middleware(['auth:api']);

