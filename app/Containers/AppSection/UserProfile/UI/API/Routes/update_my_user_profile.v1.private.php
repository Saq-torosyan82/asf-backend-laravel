<?php

/**
 * @apiGroup           UserProfile
 * @apiName            UpdateMyUserProfile
 *
 * @api                {PATCH} /v1/me/profile Update my user profile
 * @apiDescription     Update my user profile
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
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
    "borrower_mode_id": "O9apoVGyLz5qNX4K",
    "borrower_type": "corporate"
    },
    "address": {
    "city": "City53",
    "country": "AKxY1RwjQE2EN40r",
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
    "club": "0QvXO3GJ6mGkxAqY",
    "country": "AKxY1RwjQE2EN40r",
    "league": "PoZN0Ew1jzRnDbyA",
    "sport": "NxOpZowo9GmjKqdR",
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

Route::patch('me/profile', [Controller::class, 'UpdateMyUserProfile'])
    ->name('api_userprofile_update_my_user_profile')
    ->middleware(['auth:api']);

