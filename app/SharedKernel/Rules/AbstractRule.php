<?php

namespace App\SharedKernel\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class AbstractRule implements ValidationRule
{
    protected bool $skipRequestValue = false;

    protected bool $skipOnNull = false;

    abstract public function passes($attribute, $value): bool;

    abstract public function message(): string;

    public static function makeRule(): static
    {
        return app()->make(static::class);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->skipOnNull && is_null($value)) {
            return;
        }

        if (! $this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }

    public function skipRequestValue(bool $skipRequestValue = true): static
    {
        $this->skipRequestValue = $skipRequestValue;

        return $this;
    }

    public function skipOnNull(bool $skipOnNull = true): static
    {
        $this->skipOnNull = $skipOnNull;

        return $this;
    }
}
