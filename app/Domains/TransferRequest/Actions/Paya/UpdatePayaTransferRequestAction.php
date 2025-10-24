<?php

namespace App\Domains\TransferRequest\Actions\Paya;

use App\Domains\Account\Enums\AccountTransactionActionEnum;
use App\Domains\Account\Enums\AccountTransactionTypeEnum;
use App\Domains\TransferRequest\Contracts\PayaTransferRequestRepositoryContract;
use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;
use App\Domains\TransferRequest\Exceptions\PayaTransferRequestException;
use App\Domains\TransferRequest\Requests\UpdatePayaTransferRequest;
use App\SharedKernel\Constants\MorphMapConstants;
use App\SharedKernel\Contracts\Domains\AccountDomainContract;
use App\SharedKernel\DTOs\PayaTransferRequest\PayaTransferRequestDto;
use App\SharedKernel\DTOs\TransferRequest\Actions\UpdatePayaTransferRequestDto;
use Illuminate\Support\Facades\DB;

class UpdatePayaTransferRequestAction
{
    public function __construct(
        protected AccountDomainContract                 $accountDomain,
        protected PayaTransferRequestRepositoryContract $payaTransferRequestRepository,
    )
    {}

    public function controller(UpdatePayaTransferRequest $request, int $requestId)
    {
        return response()->json([
            'message' => $request->toDto()->status === PayaTransferRequestStatusEnum::CANCELED ? __('Request is Cancelled!') : __('Request is Confirmed!'),
            'request' => $this->handle($request->toDto(), $requestId)->toArray()
        ]);
    }

    public function handle(UpdatePayaTransferRequestDto $updatePayaTransferRequestDTO, int $requestId): PayaTransferRequestDto
    {
        return DB::transaction(function () use ($updatePayaTransferRequestDTO, $requestId) {

            $payaTransferRequestDTO = $this->payaTransferRequestRepository->findPayaTransferRequestByConditions(
                where: ['id' => $requestId],
                locked: true
            );

            if ($payaTransferRequestDTO->status !== PayaTransferRequestStatusEnum::PENDING)
            {
                throw PayaTransferRequestException::transferRequestAlreadyFinalized();
            }

            $accountDTO = $this->accountDomain->findAccount(
                where: ['id' => $payaTransferRequestDTO->account_id],
                locked: true
            );

            if ($accountDTO->reserved_balance < $payaTransferRequestDTO->amount)
            {
                throw PayaTransferRequestException::insufficientReservedBalance();
            }

            if ($updatePayaTransferRequestDTO->status === PayaTransferRequestStatusEnum::CONFIRMED)
            {
                $payaTransferRequestDTO = PayaTransferRequestDto::fromArray(
                    $this->payaTransferRequestRepository->update($payaTransferRequestDTO->id, [
                        'status' => PayaTransferRequestStatusEnum::CONFIRMED,
                        'confirmed_by_id' => $updatePayaTransferRequestDTO->admin_id,
                        'confirmed_by_type' => MorphMapConstants::ADMINS,
                        'confirmed_at' => now(),
                    ])->toArray()
                );

                $accountDTO = $this->accountDomain->update($accountDTO->id, [
                    'reserved_balance' => $accountDTO->reserved_balance - $payaTransferRequestDTO->amount
                ]);

                $this->accountDomain->createAccountTransaction([
                    'account_id' => $accountDTO->id,
                    'type' => AccountTransactionTypeEnum::UNLOCK,
                    'action' => AccountTransactionActionEnum::PAYA_TRANSFER_REQUEST_CONFIRM,
                    'request_id' => $payaTransferRequestDTO->id,
                    'request_type' => MorphMapConstants::PAYA_TRANSFER_REQUESTS,
                    'amount' => $payaTransferRequestDTO->amount,
                    'balance' => $accountDTO->balance,
                    'reserved_balance' => $accountDTO->reserved_balance,
                ]);

            } else {
                $payaTransferRequestDTO = PayaTransferRequestDto::fromArray(
                    $this->payaTransferRequestRepository->update($payaTransferRequestDTO->id, [
                        'status' => PayaTransferRequestStatusEnum::CANCELED,
                        'note' => $updatePayaTransferRequestDTO->note,
                        'canceled_by_id' => $updatePayaTransferRequestDTO->admin_id,
                        'canceled_by_type' => MorphMapConstants::ADMINS,
                        'canceled_at' => now(),
                    ])->toArray()
                );

                $accountDTO = $this->accountDomain->update($accountDTO->id, [
                    'balance' => $accountDTO->balance + $payaTransferRequestDTO->amount,
                    'reserved_balance' => $accountDTO->reserved_balance - $payaTransferRequestDTO->amount,
                ]);

                $this->accountDomain->createAccountTransaction([
                    'account_id' => $accountDTO->id,
                    'type' => AccountTransactionTypeEnum::UNLOCK,
                    'action' => AccountTransactionActionEnum::PAYA_TRANSFER_REQUEST_CANCEL,
                    'request_id' => $payaTransferRequestDTO->id,
                    'request_type' => MorphMapConstants::PAYA_TRANSFER_REQUESTS,
                    'amount' => $payaTransferRequestDTO->amount,
                    'balance' => $accountDTO->balance,
                    'reserved_balance' => $accountDTO->reserved_balance,
                ]);

                $this->accountDomain->createAccountTransaction([
                    'account_id' => $accountDTO->id,
                    'type' => AccountTransactionTypeEnum::INCREMENT,
                    'action' => AccountTransactionActionEnum::PAYA_TRANSFER_REQUEST_CANCEL,
                    'request_id' => $payaTransferRequestDTO->id,
                    'request_type' => MorphMapConstants::PAYA_TRANSFER_REQUESTS,
                    'amount' => $payaTransferRequestDTO->amount,
                    'balance' => $accountDTO->balance,
                    'reserved_balance' => $accountDTO->reserved_balance,
                ]);
            }

            return $payaTransferRequestDTO;
        });
    }
}
