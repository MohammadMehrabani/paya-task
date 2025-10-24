<?php

namespace App\SharedKernel\DTOs\TransferRequest\Actions;

readonly class CreatePayaTransferRequestDto
{
    public function __construct(
        public string $account_id,
        public int $price,
        public ?string $from_sheba_number = null,
        public string $to_sheba_number,
        public ?string $note = null,
    ) {}

    public static function fromArray(array $attributes): self
    {
        return new self(
            account_id: $attributes['account_id'],
            price: $attributes['price'],
            from_sheba_number: $attributes['from_sheba_number'] ?? null,
            to_sheba_number: $attributes['to_sheba_number'],
            note: $attributes['note'] ?? null
        );
    }
}
