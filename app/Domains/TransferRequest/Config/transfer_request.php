<?php

return [
    'paya' => [
        'daily_withdrawal_limit' => env('DAILY_WITHDRAWAL_LIMIT', 500000000),
        'minimum_transferable_amount' => env('MINIMUM_TRANSFER_AMOUNT', 1000000),
    ]
];
