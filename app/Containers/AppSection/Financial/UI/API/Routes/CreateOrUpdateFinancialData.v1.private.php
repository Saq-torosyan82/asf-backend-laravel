<?php

/**
 * @apiGroup           Financial
 * @apiName            CreateOrUpdateFinancialData
 *
 * @api                {POST} /v1/financials/values Create or Update Financial Data
 * @apiDescription     This endpoint is used to save or update the actual values of financial data.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Corporate User
 *
 * @apiParam           {Array}  data  The data parameter is an associative array consisting of key-value pairs. The key is the id of the financial item, and the value is the data entered by the user
 *
 * @apiParam           {String} [selected_currency] If the selected_currency parameter is sent, the values are presented according to that currency, otherwise the values are stored in the saved currency chosen by that specific sport organization
 *
 * @apiSuccessExample  Success-Response:
 * HTTP/1.1 204 OK
 No Content
 */

use App\Containers\AppSection\Financial\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('financials/values', [Controller::class, 'CreateOrUpdateFinancialData'])
    ->name('api_financial_save_financial_datas')
    ->middleware(['auth:api']);

