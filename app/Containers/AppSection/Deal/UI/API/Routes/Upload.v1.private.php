<?php

/**
 * @apiGroup           Deal
 * @apiName            Upload
 *
 * @api                {POST} /v1/deal/:id/upload Upload deal documents
 * @apiDescription     Upload deal documents
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 * @apiParam           {String}  id Deal id
 * @apiParam           {String}  upload_type Upload type
 * @apiParam           {File}    file
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  no content
}
 */

use App\Containers\AppSection\Deal\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deals/{id}/upload', [Controller::class, 'upload'])
    ->name('api_deals_upload')
    ->middleware(['auth:api']);

