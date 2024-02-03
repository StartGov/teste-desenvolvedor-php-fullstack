<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
