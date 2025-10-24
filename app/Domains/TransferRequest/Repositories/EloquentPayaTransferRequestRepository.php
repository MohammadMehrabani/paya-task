<?php

namespace App\Domains\TransferRequest\Repositories;

use App\Domains\TransferRequest\Contracts\PayaTransferRequestRepositoryContract;
use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;
use App\Models\TransferRequest\PayaTransferRequest;
use App\SharedKernel\DTOs\PayaTransferRequest\PayaTransferRequestDto;
use App\SharedKernel\Exceptions\NotFoundException;
use App\SharedKernel\Repositories\EloquentBaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPayaTransferRequestRepository extends EloquentBaseRepository implements PayaTransferRequestRepositoryContract
{
    public function model(): string
    {
        return PayaTransferRequest::class;
    }

    public function getAccountDailyTransferTotal(string $accountId): mixed
    {
        return PayaTransferRequest::query()
            ->where('account_id', $accountId)
            ->whereIn('status', [PayaTransferRequestStatusEnum::PENDING, PayaTransferRequestStatusEnum::CONFIRMED])
            ->whereBetween('confirmed_at', [now()->startOfDay(), now()->endOfDay()])
            ->sum('amount');
    }

    public function findPayaTransferRequestByConditions(array $where, array $relations = [], bool $locked = false): PayaTransferRequestDto
    {
        $payaTransferRequest = PayaTransferRequest::query()->with($relations)->where($where);

        if ($locked) {
            $payaTransferRequest->lockForUpdate();
        }

        $payaTransferRequestDTO = $payaTransferRequest->first();

        if (empty($payaTransferRequestDTO))
        {
            throw NotFoundException::resource('paya_transfer_request');
        }

        return PayaTransferRequestDto::fromArray($payaTransferRequestDTO->toArray());
    }

    public function getPayaTransferRequests(): LengthAwarePaginator
    {
        $payaTransferRequests = PayaTransferRequest::query()->orderBy('id')->paginate();

        $dtoCollection = $payaTransferRequests->getCollection()->map(function (PayaTransferRequest $model) {
            return PayaTransferRequestDto::fromArray($model->toArray());
        });

        $payaTransferRequests->setCollection($dtoCollection);

        return $payaTransferRequests;
    }
}
