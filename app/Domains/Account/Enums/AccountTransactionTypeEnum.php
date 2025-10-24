<?php

namespace App\Domains\Account\Enums;

enum AccountTransactionTypeEnum: int
{
    case INCREMENT = 1;

    case DECREMENT = 2;

    case LOCK = 3;

    case UNLOCK = 4;
}
