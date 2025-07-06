<?php

namespace App\Requests;

use App\Rules\ValidCnpj;
use App\Rules\ValidCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $documentType = $this->input('document_type');

        $documentRule = 'required';
        if ($documentType === 'CPF') {
            $documentRule = ['required', new ValidCpf];
        } elseif ($documentType === 'CNPJ') {
            $documentRule = ['required', new ValidCnpj];
        }

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.house_number' => 'required|string|max:20',
            'address.neighborhood' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|size:2',
            'document_type' => ['required', 'string', Rule::in(['CPF', 'CNPJ'])],
            'document_number' => $documentRule,
        ];
    }
}
