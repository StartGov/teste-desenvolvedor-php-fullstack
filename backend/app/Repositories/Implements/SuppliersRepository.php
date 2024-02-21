<?php

namespace App\Repositories\Implements;

use App\Models\Supplier;
use App\Models\Address;
use App\Repositories\SuppliersRepositoryInterface;

class SuppliersRepository implements SuppliersRepositoryInterface
{
    public function create($data)
    {
        $address = Address::create([
            'addres' => $data['address']['address'],
            'number' => $data['address']['number'],
            'neighborhood' => $data['address']['neighborhood'],
            'city' => $data['address']['city'],
            'state' => $data['address']['state'],
            'cep' => $data['address']['cep'],
        ]); 

        return Supplier::create([
            'social_reason' => $data['social_reason'],
            'fantasy_name' => $data['fantasy_name'],
            'contact' => $data['contact'],
            'cnpj' => $data['cnpj'],
            'addres_id' => $address->id,
        ]);
    }

    public function findById($id){
        return Supplier::findOrFail($id);
    }

    public function update($data, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);

        $address = Address::findOrFail($supplier->addres_id);
        $address->update($data['address']);

        return $supplier;
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
    }

    public function getPaginate($filters, $perPage)
    {
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

        return $suppliers;
    }
}
