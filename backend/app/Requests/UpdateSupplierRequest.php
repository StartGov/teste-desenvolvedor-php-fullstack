<?php

namespace App\Requests;

use App\Rules\ValidCnpj;
use App\Rules\ValidCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $documentType = $this->input('document_type');

        $documentRule = 'sometimes|required';
        if ($documentType === 'CPF') {
            $documentRule = ['sometimes', 'required', new ValidCpf];
        } elseif ($documentType === 'CNPJ') {
            $documentRule = ['sometimes', 'required', new ValidCnpj];
        }

        return [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'sometimes|required|array',
            'address.street' => 'sometimes|required|string|max:255',
            'address.house_number' => 'sometimes|required|string|max:20',
            'address.neighborhood' => 'sometimes|required|string|max:255',
            'address.city' => 'sometimes|required|string|max:255',
            'address.state' => 'sometimes|required|string|size:2',
            'document_type' => ['sometimes', 'required', 'string', Rule::in(['CPF', 'CNPJ'])],
            'document_number' => $documentRule,
        ];
    }
}
