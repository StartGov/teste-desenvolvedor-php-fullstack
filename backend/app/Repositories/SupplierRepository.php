<?php

namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository
{
    public function __construct(protected Supplier $supplier) {}

    public function getAllSuppliers(int $perPage = 5, array $filters = [], ?string $sortBy = null)
    {
        $query = $this->supplier->query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['document_type'])) {
            $query->where('document_type', $filters['document_type']);
        }

        if (isset($filters['document_number'])) {
            $query->where('document_number', $filters['document_number']);
        }

        if ($sortBy) {
            $sortMap = [
                'name' => 'name',
                'document_type' => 'document_type',
                'createdAt' => 'created_at',
            ];

            if (array_key_exists($sortBy, $sortMap)) {
                $column = $sortMap[$sortBy];
                $direction = $sortBy === 'createdAt' ? 'desc' : 'asc';
                $query->orderBy($column, $direction);
            }
        }

        return $query->paginate($perPage);
    }

    public function getSupplierById($id)
    {
        return $this->supplier->find($id);
    }

    public function getSupplierByDocument(string $documentType, string $documentNumber)
    {
        return $this->supplier->where('document_type', $documentType)
                              ->where('document_number', $documentNumber)
                              ->first();
    }

    public function createSupplier(array $data)
    {
        return $this->supplier->create($data);
    }

    public function updateSupplier($id, array $data)
    {
        $supplier = $this->getSupplierById($id);
        if ($supplier) {
            $supplier->update($data);
            return $supplier;
        }
        return null;
    }

    public function deleteSupplier($id)
    {
        $supplier = $this->getSupplierById($id);
        if ($supplier) {
            $supplier->delete();
            return true;
        }
        return false;
    }
}
