<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/** @property-read string $supplier */
class StoreRequest extends FormRequest
{

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
            'cpf_cnpj' => ['required', 'min:11', 'max:14', 'unique:suppliers'],
            'nome_fantasia' => ['required'],
            'razao_social' => ['required'],
            'contato' => ['required'],
            'endereco' => ['required'],
            'numero' => ['required'],
        ];
    }
}
