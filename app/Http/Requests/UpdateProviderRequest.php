<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProviderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $providerId = $this->route('provider');

        return [
            'company_name' => 'sometimes|required|string|max:256',
            'description' => 'sometimes|required|string|max:256',
            'email' => 'sometimes|required|string|email|max:256|unique:providers,email,' . $providerId,
            'phone' => 'sometimes|required|string|digits_between:8,11|regex:/^\d+$/',
            'document_type' => 'sometimes|required|in:CPF,CNPJ',
            'document_number' => [
                'sometimes',
                'string',
                'digits_between:11,14',
                'regex:/^\d+$/',
                'unique:providers,document_number,' . $providerId,
            ],
            'address.street' => 'sometimes|required|string|max:256',
            'address.city' => 'sometimes|required|string|max:256',
            'address.number' => 'sometimes|required|string|max:20',
            'address.state' => 'sometimes|required|string|max:50',
            'address.zip_code' => 'sometimes|required|string|max:50',
            'address.country' => 'sometimes|required|string|max:50',
            'address.neighborhood' => 'sometimes|required|string|max:50',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
