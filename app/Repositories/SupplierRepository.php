<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('company_name', 'like', "%$search%")
                  ->orWhere('document_number', 'like', "%$search%");
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function find(int $id): ?Supplier
    {
        return Supplier::find($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);
        return $supplier;
    }

    public function delete(Supplier $supplier): bool
    {
        return $supplier->delete();
    }
}
