<?php

namespace App\Containers\AppSection\UserProfile\Enums;

use BenSampo\Enum\Enum;

final class Group extends Enum
{
    const GENERAL = 'general';
    const SOCIAL_MEDIA = 'social_media';
    const ACCOUNT = 'account';
    const USER = 'user';
    const ADDRESS = 'address';
    const CONTACT = 'contact';
    const COMPANY = 'company';
    const PROFESSIONAL = 'professional';
    const NEWS = 'news';
}
