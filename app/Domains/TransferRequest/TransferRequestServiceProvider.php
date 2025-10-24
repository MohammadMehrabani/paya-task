<?php

namespace App\Domains\TransferRequest;

use App\Domains\TransferRequest\Contracts\PayaTransferRequestRepositoryContract;
use App\Domains\TransferRequest\Repositories\EloquentPayaTransferRequestRepository;
use App\SharedKernel\Providers\BaseServiceProvider;
use Illuminate\Support\Facades\Route;

class TransferRequestServiceProvider extends BaseServiceProvider
{
    protected array $repositories = [
        PayaTransferRequestRepositoryContract::class => EloquentPayaTransferRequestRepository::class,
    ];

    protected array $configs = [
        __DIR__.'/Config/transfer_request.php' => 'paya.transfer_request',
    ];

    public function loadRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(__DIR__.'/Routes/api.php');
    }
}
