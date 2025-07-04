<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'document_number' => [
                'required',
                'string',
                Rule::unique('suppliers', 'document_number')->ignore($this->supplier->id),
            ],
            'company_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'address' => 'nullable|string',
            'address_number' => 'nullable|string',
            'address_complement' => 'nullable|string',
            'neighborhood' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
        ];
    }

}
