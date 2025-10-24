<?php

namespace App\Domains\Admin;

use App\Domains\Admin\Contracts\AdminRepositoryContract;
use App\SharedKernel\Contracts\Domains\AdminDomainContract;

class Main implements AdminDomainContract
{
    public function __construct(protected AdminRepositoryContract $adminRepository)
    {
    }

    public function adminExists(array $where): bool
    {
        if (! count($where)) {
            return false;
        }

        return $this->adminRepository->count($where) > 0;
    }
}
