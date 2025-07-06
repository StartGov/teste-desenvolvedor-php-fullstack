<?php

namespace App\Services;

use App\Repositories\SupplierRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupplierService
{
    public function __construct(protected SupplierRepository $supplierRepository) {}

    public function getAllSuppliers(int $perPage = 5, array $filters = [], ?string $sortBy = null)
    {
        return $this->supplierRepository->getAllSuppliers($perPage, $filters, $sortBy);
    }

    public function getSupplierById($id)
    {
        return $this->supplierRepository->getSupplierById($id);
    }

    public function getSupplierByDocument(string $documentType, string $documentNumber)
    {
        return $this->supplierRepository->getSupplierByDocument($documentType, $documentNumber);
    }

    public function fetchCpnj(string $cnpj)
    {
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/$cnpj");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function createSupplier(array $data)
    {
        return $this->supplierRepository->createSupplier($data);
    }

    public function updateSupplier($id, array $data)
    {
        return $this->supplierRepository->updateSupplier($id, $data);
    }

    public function deleteSupplier($id)
    {
        return $this->supplierRepository->deleteSupplier($id);
    }
}
