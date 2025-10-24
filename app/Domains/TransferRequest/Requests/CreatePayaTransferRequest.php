<?php

namespace App\Domains\TransferRequest\Requests;

use App\SharedKernel\DTOs\TransferRequest\Actions\CreatePayaTransferRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class CreatePayaTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price' => ['required', 'int', 'min:'.config('paya.transfer_request.paya.minimum_transferable_amount')],
            'note' => ['nullable', 'string'],
            'account_id' => ['required', 'string', 'account_exists'],
            'from_sheba_number' => ['nullable', 'string', 'valid_sheba_format'],
            'to_sheba_number' => ['required', 'string', 'valid_sheba_format'],
        ];
    }

    public function toDto(): CreatePayaTransferRequestDto
    {
        return CreatePayaTransferRequestDto::fromArray($this->validated());
    }
}
