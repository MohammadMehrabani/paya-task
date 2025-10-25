<?php

namespace App\Domains\TransferRequest\Enums;

enum PayaTransferRequestStatusEnum: int
{
    case PENDING = 1;

    case CONFIRMED = 2;

    case CANCELED = 3;

    public static function updatableStatuses(): array
    {
        return [
            self::CANCELED,
            self::CONFIRMED,
        ];
    }
}
