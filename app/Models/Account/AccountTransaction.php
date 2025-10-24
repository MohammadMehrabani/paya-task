<?php

namespace App\Models\Account;

use App\Domains\Account\Enums\AccountTransactionActionEnum;
use App\Domains\Account\Enums\AccountTransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AccountTransaction extends Model
{
    protected $fillable = [
        'account_id',
        'type',
        'action',
        'request_type',
        'request_id',
        'amount',
        'balance',
        'reserved_balance',
    ];

    protected function casts(): array
    {
        return [
            'type' => AccountTransactionTypeEnum::class,
            'action' => AccountTransactionActionEnum::class,
        ];
    }

    public function request(): MorphTo
    {
        return $this->morphTo();
    }
}
