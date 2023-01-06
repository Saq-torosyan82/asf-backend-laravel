<?php

namespace App\Containers\AppSection\UserProfile\Enums;

use App\Containers\AppSection\System\Enums\BorrowerType;
use BenSampo\Enum\Enum;

final class Key extends Enum
{
    // group social_media
    const FACEBOOK = 'facebook';
    const TWITTER = 'twitter';
    const YOUTUBE = 'youtube';
    const INSTAGRAM = 'instagram';
    const LINKEDIN = 'linkedin';

    // group account
    const BORROWER_TYPE = 'borrower_type';
    const BORROWER_MODE_ID = 'borrower_mode_id';
    const LENDER_TYPE = 'lender_type';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';

    // NEW keys
    const COUNTRY = 'country';
    const STREET = 'street';
    const STATE = 'state';
    const CITY = 'city';
    const ZIP = 'zip';
    const EMAIL = 'email';

    const PHONE = 'phone';
    const FAX = 'fax';
    const POSITION = 'position';
    const OFFICE_PHONE = 'office_phone';

    const REGISTRATION_NUMBER = 'registration_number';
    const NAME = 'name';
    const SPORTS_LIST = 'sports_list';
    const WEBSITE = 'website';

    const SPORT = 'sport';
    const LEAGUE = 'league';
    const CLUB = 'club';
    const PREVIOUS_CLUBS = 'previous_clubs';
    const AVATAR = 'avatar';
    const AGENT_NAME = 'agent_name';
    const AGENT_AVATAR = 'agent_avatar';
    const AGENCY_NAME = 'agency_name';
    const CLUB_JOINED_DATE = 'club_joined_date';
    const CONTRACT_EXPIRES = 'contract_expires';

    const CITIZENSHIP = 'citizenship';
    const DATE_OF_BIRTH = 'date_of_birth';
    const PLACE_OF_BIRTH = 'place_of_birth';

    const STADIUM_NAME = 'stadium_name';
    const STADIUM_CAPACITY = 'stadium_capacity';
    const STADIUM_YEAR_OPENED = 'stadium_year_opened';
    const STADIUM_CITY = 'stadium_city';

    const COUNTRIES_LIST = 'countries_list';
}
