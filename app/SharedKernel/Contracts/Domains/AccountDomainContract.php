<?php

namespace App\SharedKernel\Contracts\Domains;

use App\SharedKernel\DTOs\Account\AccountDto;
use App\SharedKernel\DTOs\Account\AccountTransactionDto;

interface AccountDomainContract
{
    public function findAccount(array $where, array $relations = [], bool $locked = false): AccountDto;

    public function createAccountTransaction(array $attributes): AccountTransactionDto;

    public function update(string $id, array $attributes): AccountDto;

    public function accountExists(array $where): bool;
}
