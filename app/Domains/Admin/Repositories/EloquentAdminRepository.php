<?php

namespace App\Domains\Admin\Repositories;

use App\Domains\Admin\Contracts\AdminRepositoryContract;
use App\Models\Admin\Admin;
use App\SharedKernel\Repositories\EloquentBaseRepository;

class EloquentAdminRepository extends EloquentBaseRepository implements AdminRepositoryContract
{
    public function model(): string
    {
        return Admin::class;
    }
}
