<?php

/**
 * @apiGroup           UserProfile
 * @apiName
 *
 * @api                {POST} /v1/ Reject the user
 * @apiDescription     Admin of the agency can  reject the user
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess, is agency
 *
 * @apiParam           {String}  uid
 * @apiParam           {String}  reason
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
    "account": {
    "borrower_mode_id": "ELkOxj9vqobQeZnVWd6JAmDa32P4VKXp",
    "borrower_type": "corporate"
    },
    "address": {
    "city": "City53",
    "country": "Bzk0RAq2KG1Jj5y4Gzw43roegVvQxYDP",
    "street": "Street53",
    "zip": "530000"
    },
    "company": {
    "stadium_capacity": "50000",
    "stadium_city": "Chisinau",
    "stadium_name": "Dinamo new",
    "stadium_year_opened": "2011"
    },
    "contact": {
    "office_phone": "+66 53 999 9999",
    "phone": "+66 53 000 0000",
    "position": "Position53"
    },
    "professional": {
    "club": "kLXNMp56eV20PJnkB3ygZ7zB3qGlmA1a",
    "country": "Bzk0RAq2KG1Jj5y4Gzw43roegVvQxYDP",
    "league": "oaEVxzlOM9LK12nvGdYJmp5XB6bqQZ4r",
    "sport": "zKk6P7lWD2ABeRwDVnEr8obgmN4pYjJ0",
    "sport_txt": "Football",
    "country_txt": "England"
    },
    "social_media": {
    "instagram": "",
    "linkedin": "https://www.linkedin.com/company/sheffieldunited/"
    },
    "user": []
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('user/reject', [Controller::class, 'rejectUser'])
    ->name('api_userprofile_reject_user')
    ->middleware(['auth:api']);

