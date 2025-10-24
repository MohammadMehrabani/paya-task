<?php

namespace App\Models\TransferRequest;

use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;
use App\Models\Account\Account;
use App\Models\Account\AccountTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PayaTransferRequest extends Model
{
    protected $fillable = [
        'account_id',
        'from_sheba_number',
        'to_sheba_number',
        'status',
        'amount',
        'description',
        'note',
        'confirmed_by_type',
        'confirmed_by_id',
        'confirmed_at',
        'canceled_by_type',
        'canceled_by_id',
        'canceled_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PayaTransferRequestStatusEnum::class,
            'confirmed_at' => 'datetime:Y-m-d H:i:s',
            'canceled_at' => 'datetime:Y-m-d H:i:s',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(AccountTransaction::class, 'request');
    }

    public function canceled_by(): MorphTo
    {
        return $this->morphTo();
    }

    public function confirmed_by(): MorphTo
    {
        return $this->morphTo();
    }
}
