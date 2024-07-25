<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProviderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name' => 'required|string|max:256',
            'description' => 'required|string|max:256',
            'email' => 'required|string|email|max:256|unique:providers,email',
            'document_type' => 'required|in:CPF,CNPJ',
            'phone' => 'required|string|digits_between:8,11|regex:/^\d+$/',
            'document_number' => [
                'required',
                'string',
                'digits_between:11,14',
                'regex:/^\d+$/',
                'unique:providers,document_number'
            ],
            'address.street' => 'required|string|max:256',
            'address.city' => 'required|string|max:256',
            'address.number' => 'required|string|max:20',
            'address.state' => 'required|string|max:50',
            'address.zip_code' => 'required|string|max:50',
            'address.country' => 'required|string|max:50',
            'address.neighborhood' => 'required|string|max:50',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
