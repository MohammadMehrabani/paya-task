<?php

namespace App\Domains\Account\Repositories;

use App\Domains\Account\Contracts\AccountRepositoryContract;
use App\Models\Account\Account;
use App\SharedKernel\DTOs\Account\AccountDto;
use App\SharedKernel\Exceptions\NotFoundException;
use App\SharedKernel\Repositories\EloquentBaseRepository;

class EloquentAccountRepository extends EloquentBaseRepository implements AccountRepositoryContract
{
    public function model(): string
    {
        return Account::class;
    }

    public function findAccountByConditions(array $where, array $relations = [], bool $locked = false): AccountDto
    {
        $account = Account::query()->with($relations)->where($where);

        if ($locked) {
            $account->lockForUpdate();
        }

        $accountDTO = $account->first();

        if (empty($accountDTO))
        {
            throw NotFoundException::resource('account');
        }

        return AccountDto::fromArray($accountDTO->toArray());
    }
}
