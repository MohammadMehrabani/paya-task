<?php

namespace App\SharedKernel\DTOs\PayaTransferRequest;

use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;

readonly class PayaTransferRequestDto
{
    public function __construct(
        public int $id,
        public string $account_id,
        public string $from_sheba_number,
        public string $to_sheba_number,
        public PayaTransferRequestStatusEnum $status,
        public int $amount,
        public ?string $description = null,
        public ?string $note = null,
        public ?string $confirmed_by_type = null,
        public ?string $confirmed_by_id = null,
        public ?string $confirmed_at = null,
        public ?string $canceled_by_type = null,
        public ?string $canceled_by_id = null,
        public ?string $canceled_at = null,
        public string $created_at,
        public string $updated_at,
    ) {}

    public static function fromArray(array $attributes): self
    {
        return new self(
            id: $attributes['id'],
            account_id: $attributes['account_id'],
            from_sheba_number: $attributes['from_sheba_number'],
            to_sheba_number: $attributes['to_sheba_number'],
            status: isset($attributes['status'])
                ? PayaTransferRequestStatusEnum::from($attributes['status'])
                : PayaTransferRequestStatusEnum::PENDING,
            amount: $attributes['amount'],
            description: $attributes['description'] ?? null,
            note: $attributes['note'] ?? null,
            confirmed_by_type: $attributes['confirmed_by_type'] ?? null,
            confirmed_by_id: $attributes['confirmed_by_id'] ?? null,
            confirmed_at: $attributes['confirmed_at'] ?? null,
            canceled_by_type: $attributes['canceled_by_type'] ?? null,
            canceled_by_id: $attributes['canceled_by_id'] ?? null,
            canceled_at: $attributes['canceled_at'] ?? null,
            created_at: $attributes['created_at'],
            updated_at: $attributes['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'account_id' => $this->account_id,
            'from_sheba_number' => $this->from_sheba_number,
            'to_sheba_number' => $this->to_sheba_number,
            'status' => $this->status,
            'amount' => $this->amount,
            'description' => $this->description,
            'note' => $this->note,
            'confirmed_by_type' => $this->confirmed_by_type,
            'confirmed_by_id' => $this->confirmed_by_id,
            'confirmed_at' => $this->confirmed_at,
            'canceled_by_type' => $this->canceled_by_type,
            'canceled_by_id' => $this->canceled_by_id,
            'canceled_at' => $this->canceled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
