<?php

namespace App\Domains\Account\Repositories;

use App\Domains\Account\Contracts\AccountTransactionRepositoryContract;
use App\Models\Account\AccountTransaction;
use App\SharedKernel\Repositories\EloquentBaseRepository;

class EloquentAccountTransactionRepository extends EloquentBaseRepository implements AccountTransactionRepositoryContract
{
    public function model(): string
    {
        return AccountTransaction::class;
    }
}
