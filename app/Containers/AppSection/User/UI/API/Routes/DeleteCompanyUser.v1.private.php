<?php

/**
 * @apiGroup           User
 * @apiName            deleteCompanyUser
 * @api                {DELETE} /v1/company-user/id Delete Company User
 * @apiDescription     Delete Company User
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('company-user/{id}', [Controller::class, 'deleteCompanyUser'])
    ->name('api_user_delete_company_user')
    ->middleware(['auth:api']);
