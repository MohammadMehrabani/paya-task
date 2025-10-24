<?php

namespace App\Domains\Account;

use App\Domains\Account\Contracts\AccountRepositoryContract;
use App\Domains\Account\Contracts\AccountTransactionRepositoryContract;
use App\Domains\Account\Repositories\EloquentAccountRepository;
use App\Domains\Account\Repositories\EloquentAccountTransactionRepository;
use App\SharedKernel\Providers\BaseServiceProvider;

class AccountServiceProvider extends BaseServiceProvider
{
    protected array $repositories = [
        AccountRepositoryContract::class => EloquentAccountRepository::class,
        AccountTransactionRepositoryContract::class => EloquentAccountTransactionRepository::class,
    ];
}
