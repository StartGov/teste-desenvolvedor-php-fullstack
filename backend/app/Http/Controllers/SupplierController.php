<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Address;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller {

    public function store(StoreSupplierRequest $request) {
        // dd(3);
        $address = Address::create([
            'addres' => $request->address['address'],
            'number' => $request->address['number'],
            'neighborhood' => $request->address['neighborhood'],
            'city' => $request->address['city'],
            'state' => $request->address['state'],
            'cep' => $request->address['cep'],
        ]); 

        $supplier = Supplier::create([
            'social_reason' => $request->social_reason,
            'fantasy_name' => $request->fantasy_name,
            'contact' => $request->contact,
            'cnpj' => $request->cnpj,
            'addres_id' => $address->id,
        ]);

        return response()->json(['message' => 'Fornecedor criado com sucesso', 'supplier' => $supplier], 201);
    }

    public function update(Request $request, $id) {
        $supplier = Supplier::findOrFail($id);

        // $request->validate([
        //     'social_reason' => 'required|string',
        //     'fantasy_name' => 'required|string',
        //     'contact' => 'required|string',
        //     'cnpj' => 'required|string|unique:supplier,cnpj,' . $supplier->id,
        // ]);

        $supplier->update([
            'social_reason' => $request->social_reason,
            'fantasy_name' => $request->fantasy_name,
            'contact' => $request->contact,
            'cnpj' => $request->cnpj,
        ]);
        return response()->json(['message' => 'Fornecedor atualizado com sucesso', 'supplier' => $supplier]);
    }

    public function delete($id) {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return response()->json(['message' => 'Fornecedor excluído com sucesso']);
    }

    public function list(Request $request) {
        $filters = $request->only(['social_reason', 'cnpj', 'order_by', 'order']);

        $perPage = $request->input('per_page', 10);
    
        $query = Supplier::query();
    
        if (!empty($filters['social_reason'])) {
            $query->where('social_reason', 'like', '%' . $filters['social_reason'] . '%');
        }
        if (!empty($filters['cnpj'])) {
            $query->where('cnpj', $filters['cnpj']);
        }
    
        $orderBy = $filters['order_by'] ?? 'created_at';
        $order = $filters['order'] ?? 'desc';
        $query->orderBy($orderBy, $order);
    
        $suppliers = $query->with('address')->paginate($perPage);
    
        return response()->json($suppliers);
    }
}
