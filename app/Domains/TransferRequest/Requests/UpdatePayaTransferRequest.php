<?php

namespace App\Domains\TransferRequest\Requests;

use App\Domains\TransferRequest\Enums\PayaTransferRequestStatusEnum;
use App\SharedKernel\DTOs\TransferRequest\Actions\UpdatePayaTransferRequestDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePayaTransferRequest extends FormRequest
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
            'status' => [
                'required',
                'int',
                Rule::in(array_column(PayaTransferRequestStatusEnum::cases(), 'value'))
            ],
            'note' => [
                'required_if:status,'.PayaTransferRequestStatusEnum::CANCELED->value,
                'nullable',
                'string'
            ],
            'admin_id' => ['required', 'int', 'admin_exists']
        ];
    }

    public function toDto(): UpdatePayaTransferRequestDto
    {
        return UpdatePayaTransferRequestDto::fromArray($this->validated());
    }
}
