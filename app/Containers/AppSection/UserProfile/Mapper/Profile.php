<?php

namespace App\Containers\AppSection\UserProfile\Mapper;


use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;

class Profile
{
    const SECTION_LENDER = 'lender';
    const SECTION_CONTACT = 'contact';

    const API_LENDER_MAP = [
        self::SECTION_LENDER => [
            'name' => ['group' => Group::COMPANY, 'key' => Key::NAME],
            'companyRegistrationNumber' => ['group' => Group::COMPANY, 'key' => Key::REGISTRATION_NUMBER],
            'phone' => ['group' => Group::COMPANY, 'key' => Key::PHONE],
            'fax' => ['group' => Group::COMPANY, 'key' => Key::FAX],
            'website' => ['group' => Group::COMPANY, 'key' => Key::WEBSITE],
            'country' => ['group' => Group::COMPANY, 'key' => Key::COUNTRY],
            'street' => ['group' => Group::COMPANY, 'key' => Key::STREET],
            'state' => ['group' => Group::COMPANY, 'key' => Key::STATE],
            'city' => ['group' => Group::COMPANY, 'key' => Key::CITY],
            'zip' => ['group' => Group::COMPANY, 'key' => Key::ZIP],
            'type' => ['group' => Group::ACCOUNT, 'key' => Key::LENDER_TYPE]
        ],
        self::SECTION_CONTACT => [
            'position' => ['group' => Group::CONTACT, 'key' => Key::POSITION],
            'phoneNumber' => ['group' => Group::CONTACT, 'key' => Key::PHONE],
            'officeNumber' => ['group' => Group::CONTACT, 'key' => Key::OFFICE_PHONE],
            'email' => ['group' => Group::CONTACT, 'key' => Key::EMAIL]
        ]
    ];

    const PROFILE_MAP = [
        Group::ADDRESS => [
            Key::COUNTRY => [
//                'use_hash' => true,
                'has_relation' => 'countries',
                'addt_fields' => [
                    'code' => 'country_code'
                ],
            ],
            Key::STREET => 1,
            Key::STATE => [
                'is_required' => false,
            ],
            Key::CITY => 1,
            Key::ZIP => 1
        ],
        Group::CONTACT => [
            Key::PHONE => 1,
            Key::POSITION => 1,
            Key::OFFICE_PHONE => 1
        ],
        Group::COMPANY => [
            Key::REGISTRATION_NUMBER => 1,
            Key::NAME => 1,
            Key::SPORTS_LIST => [
                'is_array' => true,
                'has_relation' => 'sports',
            ],
            Key::COUNTRY => [
                'for_lender' => true,
                'is_required' => false,
                'has_relation' => 'countries',
                'addt_fields' => [
                    'code' => 'country_code'
                ],
//                'use_hash' => true,
            ],
            Key::STADIUM_NAME => [
                'is_required' => false,
            ],
            Key::STADIUM_CAPACITY => [
                'is_required' => false,
            ],
            Key::STADIUM_YEAR_OPENED => [
                'is_required' => false,
            ],
            Key::STADIUM_CITY => [
                'is_required' => false,
            ],
        ],
        Group::SOCIAL_MEDIA => [
            Key::FACEBOOK => [
                'is_required' => false,
            ],
            Key::TWITTER => [
                'is_required' => false,
            ],
            Key::YOUTUBE => [
                'is_required' => false,
            ],
            Key::INSTAGRAM => [
                'is_required' => false,
            ],
            Key::LINKEDIN => [
                'is_required' => false,
            ],
        ],
        Group::PROFESSIONAL => [
            Key::SPORT => [
                'has_relation' => 'sports',
                'dashboard_has_id' => true,
//                'use_hash' => true,
            ],
            Key::COUNTRY => [
                'has_relation' => 'countries',
                'addt_fields' => [
                    'code' => 'country_code'
                ],
//                'use_hash' => true,
            ],
            Key::LEAGUE => [
                'has_relation' => 'sport_leagues',
                'dashboard_has_id' => true,
//                'use_hash' => true,
            ],
            Key::CLUB => [
                'has_relation' => 'sport_clubs',
                'dashboard_has_id' => true,
//                'use_hash' => true,
            ],
            Key::PREVIOUS_CLUBS => [
                'has_relation' => 'sport_clubs',
                'is_array' => true,
                'is_required' => false,
            ],
            Key::AGENT_NAME => [
                'is_required' => false,
            ],
            Key::AGENT_AVATAR => [
                'is_required' => false,
                'is_file' => true,
            ],
            Key::AGENCY_NAME => [
                'is_required' => false,
            ],
            Key::CLUB_JOINED_DATE => [
                'is_required' => false,
            ],
            Key::CONTRACT_EXPIRES => [
                'is_required' => false,
            ],
        ],
        Group::ACCOUNT => [
            Key::BORROWER_TYPE => 1,
            Key::BORROWER_MODE_ID => [
                'has_relation' => 'borrower_types',
                'dashboard_skip_relation' => true,
            ],
            Key::FIRST_NAME => 1,
            Key::LAST_NAME => 1
        ],
        Group::USER => [
            Key::AVATAR => [
                'is_file' => true,
                'for_lender' => true,
            ],
            Key::DATE_OF_BIRTH => [
                'is_required' => false,
            ],
            Key::PLACE_OF_BIRTH => [
                'is_required' => false,
            ],
            Key::CITIZENSHIP => [
                'has_relation' => 'countries',
                'is_required' => false,
//                'use_hash' => true,
            ],

        ]
    ];

    const BORROWER_MAP = [
        BorrowerType::AGENT => [
            // SEEMEk: add here more !!!
            Group::ADDRESS => self::PROFILE_MAP[Group::ADDRESS],
            Group::COMPANY => self::PROFILE_MAP[Group::COMPANY],
            Group::USER => self::PROFILE_MAP[Group::USER],
//            Group::CONTACT => self::PROFILE_MAP[Group::CONTACT],
        ],
        BorrowerType::ATHLETE => [
            Group::ADDRESS => self::PROFILE_MAP[Group::ADDRESS],
            Group::USER => self::PROFILE_MAP[Group::USER],
            Group::PROFESSIONAL => self::PROFILE_MAP[Group::PROFESSIONAL],
            Group::SOCIAL_MEDIA => self::PROFILE_MAP[Group::SOCIAL_MEDIA],
            Group::CONTACT => [self::PROFILE_MAP[Group::CONTACT][Key::PHONE]]
        ],
        BorrowerType::CORPORATE => [
            Group::ACCOUNT => self::PROFILE_MAP[Group::ACCOUNT],
            Group::USER => self::PROFILE_MAP[Group::USER],
            Group::PROFESSIONAL => self::PROFILE_MAP[Group::PROFESSIONAL],
            Group::SOCIAL_MEDIA => self::PROFILE_MAP[Group::SOCIAL_MEDIA],
            Group::CONTACT => self::PROFILE_MAP[Group::CONTACT],
        ],
    ];

    public static function getProfileMap($borrowerType)
    {
        return isset(self::BORROWER_MAP[$borrowerType]) ? self::BORROWER_MAP[$borrowerType] : [];
    }

    public static function useHashValue($group, $key)
    {
        if (isset(self::PROFILE_MAP[$group]) && isset(self::PROFILE_MAP[$group][$key]) && isset(self::PROFILE_MAP[$group][$key]['use_hash']) && isset(self::PROFILE_MAP[$group][$key]['use_hash'])) {
            return true;
        }

        return false;
    }

    public static function isRequiredField($group, $key, $user_type)
    {
        if (!self::isValidField($group, $key, $user_type)) {
            return false;
        }

        if (!isset(self::PROFILE_MAP[$group][$key]['is_required'])) {
            return true;
        }

        return self::PROFILE_MAP[$group][$key]['is_required'];
    }

    public static function isLenderRequiredField($section, $field)
    {
        if (!isset(self::API_LENDER_MAP[$section]) || !isset(self::API_LENDER_MAP[$section][$field])) {
            return false;
        }

        $config = self::API_LENDER_MAP[$section][$field];

        if (isset($config['is_required'])) {
            return $config['is_required'];
        }

        return self::isRequiredField($config['group'], $config['key']);
    }

    public static function isValidField($group, $key, $user_type)
    {
        if ($user_type == PermissionType::LENDER) {
            return self::isValidLenderField($group, $key);
        }

        // SEEMEk: add user_type validation
        return isset(self::PROFILE_MAP[$group][$key]);
    }

    /**
     * @param $group
     * @param $key
     * @return bool
     */
    public static function isValidLenderField($group, $key)
    {
        if (isset(self::PROFILE_MAP[$group]) && isset(self::PROFILE_MAP[$group][$key]) && isset(self::PROFILE_MAP[$group][$key]['for_lender']) && self::PROFILE_MAP[$group][$key]['for_lender']) {
            return true;
        }
        foreach (self::API_LENDER_MAP as $section) {
            foreach ($section as $row) {
                if (($row['group'] == $group) && ($row['key'] == $key)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function getFieldConfig($group, $key, $user_type)
    {
        if ($user_type == PermissionType::LENDER) {
            if (!self::isValidLenderField($group, $key)) {
                return false;
            }

            if (isset(self::PROFILE_MAP[$group][$key]['for_lender']) && self::PROFILE_MAP[$group][$key]['for_lender']) {
                return self::PROFILE_MAP[$group][$key];
            }

            return false;
        }

        return self::isValidField($group, $key, $user_type) ? self::PROFILE_MAP[$group][$key] : null;
    }

    public static function getFieldRelation($group, $key)
    {
        return (isset(self::PROFILE_MAP[$group][$key]) && isset(self::PROFILE_MAP[$group][$key]['has_relation'])) ? self::PROFILE_MAP[$group][$key]['has_relation'] : '';
    }

    public static function fieldHasRelation($group, $key)
    {
        return isset(self::PROFILE_MAP[$group][$key]) && isset(self::PROFILE_MAP[$group][$key]['has_relation']);
    }

    public static function isFile($group, $key)
    {
        return (isset(self::PROFILE_MAP[$group][$key]) && isset(self::PROFILE_MAP[$group][$key]['is_file']));
    }

    public static function getLenderProfileMap()
    {
        $data = [];
        foreach (self::API_LENDER_MAP as $section) {
            foreach ($section as $row) {
                $data[$row['group']][$row['key']] = 1;
            }
        }

        return $data;
    }
}
