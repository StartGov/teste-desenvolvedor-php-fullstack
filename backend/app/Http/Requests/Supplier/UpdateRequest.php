<?php

namespace App\Http\Requests\Supplier;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** @property-read string $supplier */
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

        /** @var Supplier $supplier */
        $supplier = $this->route()->supplier;
        return [
            'cpf_cnpj' => ['required', 'min:11', 'max:14', Rule::unique('suppliers')->ignoreModel($supplier)],
            'nome_fantasia' => ['required'],
            'razao_social' => ['required'],
            'contato' => ['required'],
            'endereco' => ['required'],
            'numero' => ['required'],
        ];
    }
}
