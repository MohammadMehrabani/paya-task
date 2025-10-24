<?php

namespace App\SharedKernel\Contracts\Domains;

interface AdminDomainContract
{
    public function adminExists(array $where): bool;
}
