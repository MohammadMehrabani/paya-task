<?php

use App\Domains\TransferRequest\Actions\Paya\ListPayaTransferRequestAction;
use Illuminate\Support\Facades\Route;
use App\Domains\TransferRequest\Actions\Paya\CreatePayaTransferRequestAction;
use App\Domains\TransferRequest\Actions\Paya\UpdatePayaTransferRequestAction;

Route::get('sheba', [ListPayaTransferRequestAction::class, 'controller']);
Route::post('sheba', [CreatePayaTransferRequestAction::class, 'controller']);
Route::put('sheba/{requestId}', [UpdatePayaTransferRequestAction::class, 'controller']);
