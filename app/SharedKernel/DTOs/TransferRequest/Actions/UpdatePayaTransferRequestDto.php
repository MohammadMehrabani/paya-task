<?php

namespace App\SharedKernel\DTOs\TransferRequest\Actions;

use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;

readonly class UpdatePayaTransferRequestDto
{
    public function __construct(
        public PayaTransferRequestStatusEnum $status,
        public int $admin_id,
        public ?string $note = null,
    ) {}

    public static function fromArray(array $attributes): self
    {
        return new self(
            status: PayaTransferRequestStatusEnum::from($attributes['status']),
            admin_id: $attributes['admin_id'],
            note: $attributes['note'] ?? null
        );
    }
}
