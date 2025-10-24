<?php

namespace App\SharedKernel\DTOs\Account;

use App\Domains\Account\Enums\AccountStatusEnum;
use App\Domains\Account\Enums\AccountTypeEnum;

class AccountDto
{
    public function __construct(
        public string $id,
        public string $iban,
        public int $user_id,
        public AccountTypeEnum $type,
        public AccountStatusEnum $status,
        public int $balance,
        public int $reserved_balance,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromArray(array $attributes): self
    {
        return new self(
            id: $attributes['id'],
            iban: $attributes['iban'],
            user_id: $attributes['user_id'],
            type: AccountTypeEnum::from($attributes['type']),
            status: AccountStatusEnum::from($attributes['status']),
            balance: $attributes['balance'],
            reserved_balance: $attributes['reserved_balance'],
            created_at: $attributes['created_at'],
            updated_at: $attributes['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'iban' => $this->iban,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'status' => $this->status,
            'balance' => $this->balance,
            'reserved_balance' => $this->reserved_balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
