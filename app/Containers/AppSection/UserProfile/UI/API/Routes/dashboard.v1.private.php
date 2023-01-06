<?php

/**
 * @apiGroup           UserProfile
 * @apiName            GetMyProfile
 *
 * @api                {GET} /v1/me/dashboard Get dashboard data
 * @apiDescription     Get dashboard data
 *
 * @apiVersion         1.0.0
 * @apiPermission      hasAccess
 *
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 * Admin dashboard data
{
    "user": {
    "avatar": ""
    },
    "stats": {
    "lenders": {
    "total": 25,
    "data": [
    {
    "label": "Bank",
    "number": 5
    },
    {
    "label": "Private Credit Fund",
    "number": 10
    },
    {
    "label": "Family Office",
    "number": 10
    }
    ]
    },
    "borrowers": {
    "total": 76,
    "data": [
    {
    "label": "Financial Manager",
    "number": 1
    },
    {
    "label": "Professional Athlete",
    "number": 49
    },
    {
    "label": "Sports Agent",
    "number": 4
    },
    {
    "label": "Sports Organization",
    "number": 15
    },
    {
    "label": "Sports Marketing Agency",
    "number": 7
    }
    ]
    },
    "deals": {
    "total": 93,
    "data": [
    {
    "number": 3,
    "label": "Agent fees"
    },
    {
    "number": 67,
    "label": "Endorsement"
    },
    {
    "number": 1,
    "label": "Media rights"
    },
    {
    "number": 19,
    "label": "Player advance"
    },
    {
    "number": 3,
    "label": "Player transfer"
    }
    ]
    },
    "sport": {
    "total": 93,
    "data": [
    {
    "number": 86,
    "label": "Football"
    },
    {
    "number": 1,
    "label": "NBA"
    },
    {
    "number": 4,
    "label": "NHL"
    },
    {
    "number": 2,
    "label": "Boxing"
    }
    ]
    },
    "country": {
    "data": [
    {
    "label": "Albania",
    "number": 4,
    "key": "ALB"
    },
    {
    "label": "Austria",
    "number": 1,
    "key": "AUT"
    },
    {
    "label": "Belgium",
    "number": 1,
    "key": "BEL"
    },
    {
    "label": "England",
    "number": 16,
    "key": "ENG"
    },
    {
    "label": "France",
    "number": 63,
    "key": "FRA"
    },
    {
    "label": "Netherlands",
    "number": 2,
    "key": "NLD"
    },
    {
    "label": "Romania",
    "number": 3,
    "key": "ROU"
    },
    {
    "label": "Spain",
    "number": 3,
    "key": "ESP"
    }
    ]
    },
    "received_money": {
    "total": "855,944.53",
    "totalInstallments": 8,
    "totalPaidInstallments": 2,
    "totalOutstanding": "2,426,659.25",
    "data": [
    0,
    0,
    0,
    0,
    1,
    1
    ]
    },
    "money": {
    "total": "1,228,431,105.67",
    "data": [
    {
    "number": 91322968.78327484,
    "key": "completed",
    "label": "Completed"
    },
    {
    "number": 342368817.71876055,
    "key": "in_progress",
    "label": "In progress"
    },
    {
    "number": 794739319.170604,
    "key": "not_started",
    "label": "Not started"
    }
    ]
    }
    },
    "account": {
    "isAgency": false
    }
}
 *
 * Corporate user
 *
 * {
        "account": {
        "borrower_mode_id": "5",
        "borrower_type": "corporate",
        "isAgency": false
        },
        "address": {
        "city": "City53",
        "country": "England",
        "country_code": "ENG",
        "street": "Street53",
        "zip": "530000"
        },
        "company": {
        "stadium_capacity": "50000",
        "stadium_city": "Chisinau",
        "stadium_name": "Dinamo new",
        "stadium_year_opened": "2011",
        "club_founded": "Jan 1, 1878",
        "club_manager": "Ole Gunnar Solskjaer",
        "club_owners": "Glazer Family (Joel, Kevin, Darcie, Bryan, Avram, Edward)"
        },
        "contact": {
        "office_phone": "+66 53 999 9999",
        "phone": "+66 53 000 0000",
        "position": "Position53"
        },
        "professional": {
        "club": "Manchester United",
        "club_id": "0QvXO3GJ6mGkxAqY",
        "country": "England",
        "country_code": "ENG",
        "league": "Premier League",
        "league_id": "PoZN0Ew1jzRnDbyA",
        "sport": "Football",
        "sport_id": "NxOpZowo9GmjKqdR",
        "league_name": "Premier League",
        "league_logo": "http://api.apiato.test/storage/logo/sport-leagues/Premier_League.png",
        "association_name": "The Football Association",
        "association_logo": "http://api.apiato.test/storage/logo/sport-associations/FA_crest.png",
        "confederation_name": "UEFA",
        "confederation_logo": "http://api.apiato.test/storage/logo/sport-confederations/uefa-logo.png"
        },
        "social_media": {
        "linkedin": {
        "link": "https://www.linkedin.com/company/sheffieldunited/",
        "nb_followers": 16262,
        "last_checked": "2022-04-10"
        },
        "last_update": "2022-04-10"
        },
        "user": {
        "avatar": "http://api.apiato.test/storage/logo/sport-clubs/manchester-united.png",
        "is_public_avatar": 1
        },
        "stats": {
        "lenders": {
        "total": 0,
        "data": []
        },
        "borrowers": {
        "total": 1,
        "data": [
        {
        "label": "Sports Organization",
        "number": 1
        }
        ]
        },
        "deals": {
        "total": 13,
        "data": [
        {
        "number": 11,
        "label": "Endorsement"
        },
        {
        "number": 2,
        "label": "Player transfer"
        }
        ]
        },
        "sport": {
        "total": 13,
        "data": [
        {
        "number": 13,
        "label": "Football"
        }
        ]
        },
        "country": {
        "data": [
        {
        "label": "England",
        "number": 13,
        "key": "ENG"
        }
        ]
        },
        "payments": {
        "data": [
        {
        "label": "",
        "installments": 0,
        "paid_installments": 0
        },
        {
        "label": "",
        "installments": 0,
        "paid_installments": 0
        },
        {
        "label": "",
        "installments": 0,
        "paid_installments": 0
        },
        {
        "label": "",
        "installments": 0,
        "paid_installments": 0
        },
        {
        "label": "",
        "installments": 0,
        "paid_installments": 0
        }
        ],
        "labels": [
        null,
        null,
        null,
        null,
        null
        ],
        "totalAmount": 0,
        "totalPayment": 0,
        "allInstallments": 0,
        "allPaidInstallments": 0
        },
        "money": {
        "total": "579,616,479.50",
        "data": [
        {
        "number": 0,
        "key": "completed",
        "label": "Completed"
        },
        {
        "number": 0,
        "key": "in_progress",
        "label": "In progress"
        },
        {
        "number": 579616479.5001285,
        "key": "not_started",
        "label": "Not started"
        }
        ]
        }
        }
}
 */

use App\Containers\AppSection\UserProfile\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('me/dashboard', [Controller::class, 'getDashboard'])
    ->name('api_userprofile_get_dashboard')
    ->middleware(['auth:api']);

