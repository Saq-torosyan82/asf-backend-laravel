<?php

/**
 * @apiGroup           Upload
 * @apiName            getAllUploads
 *
 * @api                {GET} /v1/uploads Get all uploads
 * @apiDescription     Get all uploads
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    data: [
          {
            object: '',
            id: '',
            privacy: '',
            upload_type: '',
            user_id: '',
            uploaded_by: '',
            init_file_name: '',
            file_mime: '',
            file_size: '',
            file_name: '',
            file_path: '',
        }
      ...
     ]
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('uploads', [Controller::class, 'getAllUploads'])
    ->name('api_upload_get_all_uploads')
    ->middleware(['auth:api']);

