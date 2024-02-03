<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function __invoke(StoreRequest $request)
    {
        $supplier = Supplier::create([
            'cpf_cnpj' => $request->cpf_cnpj,
            'nome_fantasia' => $request->nome_fantasia,
            'razao_social' => $request->razao_social,
            'contato' => $request->contato,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
        ]);

        return SupplierResource::make($supplier);
    }
}
