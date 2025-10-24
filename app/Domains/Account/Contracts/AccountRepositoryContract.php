<?php

namespace App\Domains\Account\Contracts;

use App\SharedKernel\Contracts\EloquentBaseRepositoryContract;
use App\SharedKernel\DTOs\Account\AccountDto;

interface AccountRepositoryContract extends EloquentBaseRepositoryContract
{
    public function findAccountByConditions(array $where, array $relations = [], bool $locked = false): AccountDto;
}
