<?php

namespace App\SharedKernel\Rules\Account;

use App\SharedKernel\Contracts\Domains\AccountDomainContract;
use App\SharedKernel\Rules\AbstractRule;

class AccountExists extends AbstractRule
{
    public function __construct(protected AccountDomainContract $accountDomain) {}

    public function passes($attribute, $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        return $this->accountDomain->accountExists(['id' => $value]);
    }

    public function message(): string
    {
        return trans('validation.exists');
    }
}
