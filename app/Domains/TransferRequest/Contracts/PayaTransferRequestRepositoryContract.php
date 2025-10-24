<?php

namespace App\Domains\TransferRequest\Contracts;

use App\SharedKernel\Contracts\EloquentBaseRepositoryContract;
use App\SharedKernel\DTOs\PayaTransferRequest\PayaTransferRequestDto;

interface PayaTransferRequestRepositoryContract extends EloquentBaseRepositoryContract
{
    public function getAccountDailyTransferTotal(string $accountId): mixed;

    public function findPayaTransferRequestByConditions(array $where, array $relations = [], bool $locked = false): PayaTransferRequestDto;
}
