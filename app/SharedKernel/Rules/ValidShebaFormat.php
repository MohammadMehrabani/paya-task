<?php

namespace App\SharedKernel\Rules;

class ValidShebaFormat extends AbstractRule
{
    public function passes($attribute, $value): bool
    {
        return preg_match('/^IR\d{24}$/', $value);
    }

    public function message(): string
    {
        return trans('validation.regex');
    }
}
