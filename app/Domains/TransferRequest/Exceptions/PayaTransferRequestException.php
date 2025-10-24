<?php

namespace App\Domains\TransferRequest\Exceptions;

use App\SharedKernel\Exceptions\ErrorException;

class PayaTransferRequestException extends ErrorException
{
    public static function belowMinimumWithdrawableBalance(): self
    {
        return new self(
           __('Insufficient balance. The requested amount exceeds the minimum withdrawable balance.')
        );
    }

    public static function exceedDailyTransferLimit(): self
    {
        return new self(__('You have reached your daily transfer limit.'));
    }

    public static function transferRequestAlreadyFinalized(): self
    {
        return new self(
            __('The transfer request is already confirmed or canceled and cannot be updated.')
        );
    }

    public static function insufficientReservedBalance(): self
    {
        return new self(
            __('The reserved balance is insufficient to complete this transfer.')
        );
    }

    public static function invalidTransferAmount(): self
    {
        return new self(
            __('Transfer amount must be greater than '.
                config('paya.transfer_request.paya.minimum_transferable_amount'). '.'
            )
        );
    }
}
