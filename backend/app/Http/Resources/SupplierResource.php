<?php

namespace App\Http\Resources;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        /** @var Supplier $this */
        return [
            'id'         => $this->id,
            'cpf_cnpj' => $this->cpf_cnpj,
            'nome_fantasia' => $this->nome_fantasia,
            'razao_social' => $this->razao_social,
            'contato' => $this->contato,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'created_at' => $this->created_at->format('Y-m-d h:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d h:i:s'),
        ];
    }
}
