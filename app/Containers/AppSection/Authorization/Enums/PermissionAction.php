<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Enums;

use BenSampo\Enum\Enum;

final class PermissionAction extends Enum
{
    const VIEW = 'view';
    const LIST = 'list';
    const ACCESS = 'access';
    const SERACH = 'search';

    const MANAGE = 'manage';
    const EDIT = 'edit';
    const ADD = 'add';

    const DELETE = 'delete';
}
