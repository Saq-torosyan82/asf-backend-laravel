<?php

/**
 * @apiGroup           UserProfile
 * @apiName            SaveOnboardingLender
 *
 * @api                {ONBOARDING/LENDER} /v1/onboarding/lender Lender onboarding
 * @apiDescription     Lender onboarding
 *
 * @apiVersion         1.0.0
 * @apiPermission      User is ADMIN
 *
 * @apiParam           {String}  lender.email
 * @apiParam           {String}  lender.name
 * @apiParam           {String}  lender.type
 * @apiParam           {String}  lender.country
 * @apiParam           {String}  lender.street
 * @apiParam           {String}  lender.city
 * @apiParam           {String}  lender.zip
 * @apiParam           {String}  lender.companyRegistrationNumber
 * @apiParam           {String}  lender.website
 * @apiParam           {String}  lender.phone
 * @apiParam           {String}  contact.firstName
 * @apiParam           {String}  contact.lastName
 * @apiParam           {String}  contact.position
 * @apiParam           {String}  contact.phoneNumber
 * @apiParam           {String}  contact.officeNumber
 * @apiParam           {String}  contact.email
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

Route::post('onboarding/lender', [Controller::class, 'SaveOnboardingLender'])
    ->name('api_userprofile_save_onboarding_lender')
    ->middleware(['auth:api']);

