<?php

/**
 * @apiGroup           Upload
 * @apiName            findUploadById
 *
 * @api                {GET} /v1/uploads/:id Find document by id
 * @apiDescription     Find document by id
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Upload id
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
      data: {
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
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('uploads/{id}', [Controller::class, 'findUploadById'])
    ->name('api_upload_find_upload_by_id')
    ->middleware(['auth:api']);

