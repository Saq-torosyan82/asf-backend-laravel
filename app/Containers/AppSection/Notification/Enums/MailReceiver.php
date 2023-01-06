<?php

namespace App\Containers\AppSection\Notification\Enums;

use BenSampo\Enum\Enum;

final class MailReceiver extends Enum
{
    const ADMIN = 'admin';
    const BORROWER = 'borrower';
    const LENDER = 'lender';
    const PARENT = 'parent';
    const PARTICIPANT = 'participant';
}
