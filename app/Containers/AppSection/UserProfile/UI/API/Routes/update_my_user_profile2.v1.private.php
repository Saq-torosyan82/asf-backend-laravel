<?php

/**
 * @apiGroup           UserProfile
 * @apiName            UpdateMyUserProfile
 *
 * @api                {POST} /v1/me/profile Update my user profile 2
 * @apiDescription     Update my user profile 2
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  account.borrower_mode_id
 * @apiParam           {String}  account.borrower_type
 * @apiParam           {String}  address.city
 * @apiParam           {String}  address.country
 * @apiParam           {String}  address.street
 * @apiParam           {String}  address.zip
 * @apiParam           {String}  company.stadium_capacity
 * @apiParam           {String}  company.stadium_city
 * @apiParam           {String}  company.stadium_name
 * @apiParam           {String}  company.stadium_year_opened
 * @apiParam           {String}  contact.office_phone
 * @apiParam           {String}  contact.phone
 * @apiParam           {String}  contact.position
 * @apiParam           {String}  professional.club
 * @apiParam           {String}  professional.country
 * @apiParam           {String}  professional.league
 * @apiParam           {String}  professional.sport
 * @apiParam           {String}  professional.sport_txt
 * @apiParam           {String}  professional.country_txt
 * @apiParam           {String}  [social_media.instagram]
 * @apiParam           {String}  [social_media.linkedin]
 * @apiParam           {String}  [social_media.facebook]
 * @apiParam           {String}  [social_media.twitter]
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

Route::patch('me/profile2', [Controller::class, 'UpdateMyUserProfile2'])
    ->name('api_userprofile_update_my_user_profile2')
    ->middleware(['auth:api']);

