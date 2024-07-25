<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name_or_company' => 'required|string|max:255',
            'document_number' => [
                'required',
                'string',
                'max:18',
                'regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$|^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/',
                Rule::unique('suppliers')->ignore($this->supplier),
            ],
            'contact' => 'required|string|max:255',
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name_or_company.required' => 'O nome ou nome da empresa é obrigatório.',
            'document_number.required' => 'O CNPJ ou CPF é obrigatório.',
            'document_number.unique' => 'O CNPJ ou CPF já está em uso.',
            'document_number.regex' => 'O formato do CNPJ ou CPF é inválido.',
            'contact.required' => 'O contato da empresa é obrigatório.',
            'address.required' => 'O endereço da empresa é obrigatório.',
        ];
    }
}