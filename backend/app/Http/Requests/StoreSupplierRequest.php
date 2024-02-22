<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
    public function rules(): array {
    
        return [
            'social_reason' => 'required|string|max:255',
            'fantasy_name' => 'required|string',
            'contact' => 'required|string',
            'cnpj' => "required|string|unique:supplier,cnpj",
            'address.address' => 'required|string',
            'address.number' => 'required|string',
            'address.neighborhood' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string',
            'address.cep' => 'required|string',
        ];
    }

    public function messages() {
        return [
            'social_reason.required' => 'O campo razão social é obrigatório.',
            'fantasy_name.required' => 'O campo nome fantasia é obrigatório.',
            'contact.required' => 'O campo contato é obrigatório.',
            'cnpj.required' => 'O campo cnpj é obrigatório.',
            'cnpj.unique' => 'O campo cnpj já existe.',
            'address.address.required' => 'Informe o logradouro',
            'address.number.required' => 'O numero é obrigatório.',
            'address.neighborhood.required' => 'O campo bairro é obrigatório.',
            'address.city.required' => 'O campo cidade é obrigatório.',
            'address.state.required' => 'O campo estado é obrigatório.',
            'address.cep.required' => 'O campo CEP é obrigatório.',
        ];  
    }
}
