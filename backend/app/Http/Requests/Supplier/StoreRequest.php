<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

/** @property-read string $supplier */
class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cpf_cnpj' => ['required', 'min:11', 'max:14', 'unique:suppliers'],
            'nome_fantasia' => ['required'],
            'razao_social' => ['required']
        ];
    }
}
