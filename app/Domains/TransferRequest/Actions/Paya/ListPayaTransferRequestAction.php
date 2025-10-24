<?php

namespace App\Domains\TransferRequest\Actions\Paya;

use App\Domains\TransferRequest\Contracts\PayaTransferRequestRepositoryContract;

class ListPayaTransferRequestAction
{
    public function __construct(protected PayaTransferRequestRepositoryContract $repository)
    {
    }

    public function controller(): array
    {
        return $this->handle()->toArray();
    }

    public function handle()
    {
        return $this->repository->getPayaTransferRequests();
    }
}
