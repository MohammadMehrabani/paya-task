<?php

namespace App\Domains\Account;

use App\Domains\Account\Contracts\AccountRepositoryContract;
use App\Domains\Account\Contracts\AccountTransactionRepositoryContract;
use App\SharedKernel\Contracts\Domains\AccountDomainContract;
use App\SharedKernel\DTOs\Account\AccountDto;
use App\SharedKernel\DTOs\Account\AccountTransactionDto;

class Main implements AccountDomainContract
{
    public function __construct(
        protected AccountRepositoryContract            $accountRepository,
        protected AccountTransactionRepositoryContract $accountTransactionRepository,
    )
    {}

    public function findAccount(array $where, array $relations = [], bool $locked = false): AccountDto
    {
        return $this->accountRepository->findAccountByConditions($where, $relations, $locked);
    }

    public function createAccountTransaction(array $attributes): AccountTransactionDto
    {
        return AccountTransactionDto::fromArray($this->accountTransactionRepository->create($attributes)->toArray());
    }

    public function update(string $id, array $attributes): AccountDto
    {
        return AccountDto::fromArray($this->accountRepository->update($id, $attributes)->toArray());
    }

    public function accountExists(array $where): bool
    {
        if (! count($where)) {
            return false;
        }

        return $this->accountRepository->count($where) > 0;
    }
}
