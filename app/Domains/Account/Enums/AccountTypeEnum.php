<?php

namespace App\Domains\Account\Enums;

enum AccountTypeEnum: int
{
    case CURRENT_ACCOUNT = 1;

    case SHORT_TERM_DEPOSIT = 2;

    case LONG_TERM_DEPOSIT = 3;
}
