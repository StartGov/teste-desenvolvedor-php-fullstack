<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use App\Repositories\SuppliersRepositoryInterface;

class SupplierController extends Controller {
    protected $suppliersRepository;

    public function __construct(SuppliersRepositoryInterface $suppliersRepository)
    {
        $this->suppliersRepository = $suppliersRepository;
    }

    public function store(StoreSupplierRequest $request) {
        $supplier = $this->suppliersRepository->create($request->all());

        return response()->json(['message' => 'Fornecedor criado com sucesso', 'supplier' => $supplier], 201);
    }

    public function update(UpdateSupplierRequest $request, $id) {
        $data = [
            'social_reason' => $request->social_reason,
            'fantasy_name' => $request->fantasy_name,
            'contact' => $request->contact,
            'cnpj' => $request->cnpj,
            'address' => $request->address
        ];

        $supplier = $this->suppliersRepository->update($data, $id);

        return response()->json(['message' => 'Fornecedor atualizado com sucesso', 'supplier' => $supplier]);
    }

    public function delete($id) {
        $this->suppliersRepository->delete($id);

        return response()->json(['message' => 'Fornecedor excluído com sucesso']);
    }

    public function list(Request $request) {
        $filters = $request->only(['social_reason', 'cnpj', 'order_by', 'order']);

        $perPage = $request->input('per_page', 10);
        
        $suppliers = $this->suppliersRepository->getPaginate($filters, $perPage);
    
        return response()->json($suppliers);
    }
}
