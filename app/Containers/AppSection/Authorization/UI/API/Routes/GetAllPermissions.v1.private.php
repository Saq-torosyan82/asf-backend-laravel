<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getAllPermissions
 * @api                {get} /v1/permissions Get All Permission
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 OK
{
    "data": [
        {
        "object": "Permission",
        "id": "NxOpZowo9GmjKqdR",
        "name": "manage-roles",
        "description": "Create, Update, Delete, Get All, Attach/detach permissions to Roles and Get All Permissions.",
        "display_name": null
        }
         ...
    ],
    "meta": {
    "include": [],
    "custom": [],
    "pagination": {
    "total": 26,
    "count": 10,
    "per_page": 10,
    "current_page": 1,
    "total_pages": 3,
    "links": {
    "next": "http://api.apiato.test/v1/permissions?page=2"
    }
    }
    }
}
 */


use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('permissions', [Controller::class, 'getAllPermissions'])
    ->name('api_authorization_get_all_permissions')
    ->middleware(['auth:api']);
