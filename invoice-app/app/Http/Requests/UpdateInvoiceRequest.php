<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subtotal' => ['decimal:0,2', 'min:0'],
            'total' => ['decimal:0,2', 'min:0'],
            'due_date' => ['date'],
            'status'=> [Rule::in(InvoiceStatusEnum::values())],
        ];
    }
}
