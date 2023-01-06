<?php

namespace App\Containers\AppSection\Authorization\Enums;

use BenSampo\Enum\Enum;

final class PermissionType extends Enum
{
    const BORROWER = 'borrower';
    const LENDER = 'lender';
    const ADMIN = 'admin';
}
