<?php

namespace App\Domains\Account\Enums;

enum AccountTransactionActionEnum: int
{
    case PAYA_TRANSFER_REQUEST_CREATE = 1;

    case PAYA_TRANSFER_REQUEST_CONFIRM = 2;

    case PAYA_TRANSFER_REQUEST_CANCEL = 3;
}
