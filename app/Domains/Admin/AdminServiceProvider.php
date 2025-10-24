<?php

namespace App\Domains\Admin;

use App\Domains\Admin\Contracts\AdminRepositoryContract;
use App\Domains\Admin\Repositories\EloquentAdminRepository;
use App\SharedKernel\Providers\BaseServiceProvider;

class AdminServiceProvider extends BaseServiceProvider
{
    protected array $repositories = [
        AdminRepositoryContract::class => EloquentAdminRepository::class,
    ];
}
