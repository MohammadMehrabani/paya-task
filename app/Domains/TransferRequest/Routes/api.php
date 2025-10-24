<?php

use Illuminate\Support\Facades\Route;
use App\Domains\TransferRequest\Actions\Paya\CreatePayaTransferRequestAction;
use App\Domains\TransferRequest\Actions\Paya\UpdatePayaTransferRequestAction;

Route::post('sheba', [CreatePayaTransferRequestAction::class, 'controller']);
Route::put('sheba/{requestId}', [UpdatePayaTransferRequestAction::class, 'controller']);
