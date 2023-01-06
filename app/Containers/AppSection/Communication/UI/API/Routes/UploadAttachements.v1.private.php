<?php

/**
 * @apiGroup           Communication
 * @apiName            uploadAttachments
 *
 * @api                {POST} /v1/communications/attachements Upload Attachments
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Array}  attachements Array of files
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "attachements": [
        {
            "privacy": "private",
            "user_id": 46,
            "uploaded_by": 46,
            "init_file_name": "image_1.png",
            "file_mime": "image/png",
            "file_size": 82807,
            "file_name": "image_1_1650634287.png",
            "file_path": "communications/46/image_1_1650634287.png",
            "uuid": "4a64bd68-b0ae-4aca-b01c-28e28e8afe0f",
            "updated_at": "2022-04-22T13:31:27.000000Z",
            "created_at": "2022-04-22T13:31:27.000000Z",
            "id": 309
        },…
    ]
}
 */

use App\Containers\AppSection\Communication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('communications/attachements', [Controller::class, 'attachementsUpload'])
    ->name('api_communication_upload_attachements')
    ->middleware(['auth:api']);

