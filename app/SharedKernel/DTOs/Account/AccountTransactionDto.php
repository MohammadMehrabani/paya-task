<?php

namespace App\SharedKernel\DTOs\Account;

use App\Domains\Account\Enums\AccountTransactionActionEnum;
use App\Domains\Account\Enums\AccountTransactionTypeEnum;

class AccountTransactionDto
{
    public function __construct(
        public int $id,
        public string $account_id,
        public AccountTransactionTypeEnum $type,
        public AccountTransactionActionEnum $action,
        public string $request_type,
        public int $request_id,
        public int $amount,
        public int $balance,
        public int $reserved_balance,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromArray(array $attributes): self
    {
        return new self(
            id: $attributes['id'],
            account_id: $attributes['account_id'],
            type: AccountTransactionTypeEnum::from($attributes['type']),
            action: AccountTransactionActionEnum::from($attributes['action']),
            request_type: $attributes['request_type'],
            request_id: $attributes['request_id'],
            amount: $attributes['amount'],
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
            'account_id' => $this->account_id,
            'type' => $this->type,
            'action' => $this->action,
            'request_type' => $this->request_type,
            'request_id' => $this->request_id,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'reserved_balance' => $this->reserved_balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
