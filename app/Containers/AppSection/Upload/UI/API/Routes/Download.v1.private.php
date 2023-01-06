<?php

/**
 * @apiGroup           Upload
 * @apiName            download
 *
 * @api                {GET} /v1/download/:uuid Download document
 * @apiDescription     Download document
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  uuid Document uuid
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  data: {
    filemime: '',
    filename: '',
    Access-Control-Expose-Headers: {'filename', 'filemime'},
  }
}
 */

use App\Containers\AppSection\Upload\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('download/{uuid}', [Controller::class, 'download'])
    ->name('api_upload_download')
    ->middleware(['auth:api']);

