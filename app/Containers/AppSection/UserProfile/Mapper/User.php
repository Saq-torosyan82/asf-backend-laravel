<?php

namespace App\Containers\AppSection\UserProfile\Mapper;


use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\System\Enums\BorrowerType;

class User
{
    protected static $USER_TYPE = [
        PermissionType::ADMIN => [
            'permission' => PermissionType::ADMIN,
        ],
        PermissionType::LENDER => [
            'permission' => PermissionType::LENDER,
        ],
        PermissionType::BORROWER => [
            'permission' => PermissionType::BORROWER,
        ],
        BorrowerType::CORPORATE => [
            'permission' => PermissionType::BORROWER,
        ],
        BorrowerType::ATHLETE => [
            'permission' => PermissionType::BORROWER,
        ],
        BorrowerType::AGENT => [
            'permission' => PermissionType::BORROWER,
        ]
    ];

    public static function isValidUserType($type)
    {
        return isset(static::$USER_TYPE[$type]);
    }

    public static function getUserPermission($type)
    {
        return isset(static::$USER_TYPE[$type]) ? static::$USER_TYPE[$type]['permission'] : null;
    }
}
