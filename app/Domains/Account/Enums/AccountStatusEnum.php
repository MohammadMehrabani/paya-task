<?php

namespace App\Domains\Account\Enums;

enum AccountStatusEnum: int
{
    case ACTIVE = 1;

    case INACTIVE = 2;
}
