<?php

namespace App\Domains\TransferRequest\Actions\Paya;

use App\Domains\Account\Enums\AccountTransactionActionEnum;
use App\Domains\Account\Enums\AccountTransactionTypeEnum;
use App\Domains\TransferRequest\Contracts\PayaTransferRequestRepositoryContract;
use App\Domains\TransferRequest\Exceptions\PayaTransferRequestException;
use App\Domains\TransferRequest\Requests\CreatePayaTransferRequest;
use App\SharedKernel\Constants\MorphMapConstants;
use App\SharedKernel\Contracts\Domains\AccountDomainContract;
use App\SharedKernel\DTOs\PayaTransferRequest\PayaTransferRequestDto;
use App\SharedKernel\DTOs\TransferRequest\Actions\CreatePayaTransferRequestDto;
use Illuminate\Support\Facades\DB;

class CreatePayaTransferRequestAction
{
    public function __construct(
        protected AccountDomainContract                 $accountDomain,
        protected PayaTransferRequestRepositoryContract $payaTransferRequestRepository,
    )
    {}

    public function controller(CreatePayaTransferRequest $request): array
    {
        return $this->handle($request->toDto())->toArray();
    }

    public function handle(CreatePayaTransferRequestDto $createPayaTransferRequestDTO): PayaTransferRequestDto
    {
        return DB::transaction(function () use ($createPayaTransferRequestDTO) {

            if ($createPayaTransferRequestDTO->price <= 0)
            {
                throw PayaTransferRequestException::invalidTransferAmount();
            }

            $accountDTO = $this->accountDomain->findAccount(
                where: ['id' => $createPayaTransferRequestDTO->account_id],
                locked: true
            );

            if (
                $createPayaTransferRequestDTO->price >
                ($accountDTO->balance - config('paya.minimum_withdrawable_balance'))
            )
            {
                throw PayaTransferRequestException::belowMinimumWithdrawableBalance();
            }

            if (
                $this->payaTransferRequestRepository->getAccountDailyTransferTotal($accountDTO->id)
                >=
                config('paya.transfer_request.paya.daily_withdrawal_limit')
            )
            {
                throw PayaTransferRequestException::exceedDailyTransferLimit();
            }

            $payaTransferRequestDTO = PayaTransferRequestDto::fromArray(
                $this->payaTransferRequestRepository->create([
                    'account_id' => $accountDTO->id,
                    'from_sheba_number' => $createPayaTransferRequestDTO->from_sheba_number ?? $accountDTO->iban,
                    'to_sheba_number' => $createPayaTransferRequestDTO->to_sheba_number,
                    'amount' => $createPayaTransferRequestDTO->price,
                    'description' => $createPayaTransferRequestDTO->note,
                ])->toArray()
            );

            $accountDTO = $this->accountDomain->update($accountDTO->id, [
                'balance' => ($accountDTO->balance - $createPayaTransferRequestDTO->price),
                'reserved_balance' => ($accountDTO->reserved_balance + $createPayaTransferRequestDTO->price),
            ]);

            $this->accountDomain->createAccountTransaction([
                'account_id' => $accountDTO->id,
                'type' => AccountTransactionTypeEnum::LOCK,
                'action' => AccountTransactionActionEnum::PAYA_TRANSFER_REQUEST_CREATE,
                'request_id' => $payaTransferRequestDTO->id,
                'request_type' => MorphMapConstants::PAYA_TRANSFER_REQUESTS,
                'amount' => $createPayaTransferRequestDTO->price,
                'balance' => $accountDTO->balance,
                'reserved_balance' => $accountDTO->reserved_balance,
            ]);

            $this->accountDomain->createAccountTransaction([
                'account_id' => $accountDTO->id,
                'type' => AccountTransactionTypeEnum::DECREMENT,
                'action' => AccountTransactionActionEnum::PAYA_TRANSFER_REQUEST_CREATE,
                'request_id' => $payaTransferRequestDTO->id,
                'request_type' => MorphMapConstants::PAYA_TRANSFER_REQUESTS,
                'amount' => $createPayaTransferRequestDTO->price,
                'balance' => $accountDTO->balance,
                'reserved_balance' => $accountDTO->reserved_balance,
            ]);

            return $payaTransferRequestDTO;
        });
    }
}
