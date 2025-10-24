<?php

namespace App\Models\Account;

use App\Domains\Account\Enums\AccountStatusEnum;
use App\Domains\Account\Enums\AccountTypeEnum;
use App\Models\TransferRequest\PayaTransferRequest;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'balance',
        'reserved_balance',
    ];

    protected function casts(): array
    {
        return [
            'type' => AccountTypeEnum::class,
            'status' => AccountStatusEnum::class,
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(AccountTransaction::class);
    }

    public function paya_transfer_requests(): HasMany
    {
        return $this->hasMany(PayaTransferRequest::class);
    }
}
