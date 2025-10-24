<?php

namespace App\SharedKernel\Rules\Admin;

use App\SharedKernel\Contracts\Domains\AdminDomainContract;
use App\SharedKernel\Rules\AbstractRule;

class AdminExists extends AbstractRule
{
    public function __construct(protected AdminDomainContract $adminDomain) {}

    public function passes($attribute, $value): bool
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return false;
        }

        return $this->adminDomain->adminExists(['id' => $value]);
    }

    public function message(): string
    {
        return trans('validation.exists');
    }
}
