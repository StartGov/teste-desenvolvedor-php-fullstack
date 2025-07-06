<?php

namespace App\Http\Controllers;

use App\Requests\SupplierRequest;
use App\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $supplierService) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $filters = $request->only(['name', 'document_type', 'document_number']);
        $sortBy = $request->input('sort_by');

        $suppliers = $this->supplierService->getAllSuppliers($perPage, $filters, $sortBy);
        return response()->json($suppliers);
    }

    public function show($id)
    {
        $supplier = $this->supplierService->getSupplierById($id);
        if ($supplier) {
            return response()->json($supplier);
        }
        return response()->json(['message' => 'Supplier not found'], 404);
    }

    public function showByDocument(Request $request)
    {
        $documentType = $request->input('document_type');
        $documentNumber = $request->input('document_number');

        if (!$documentType || !$documentNumber) {
            return response()->json(['message' => 'Document type and number are required'], 400);
        }

        $supplier = $this->supplierService->getSupplierByDocument($documentType, $documentNumber);
        if ($supplier) {
            return response()->json($supplier);
        }
        return response()->json(['message' => 'Supplier not found'], 404);
    }

    public function fetchCpnj(string $cnpj) {
        if (!$cnpj) {
            return response()->json(['message' => 'CNPJ is required'], 400);
        }

        $supplierData = $this->supplierService->fetchCpnj($cnpj);

        if ($supplierData) {
            return response()->json($supplierData);
        }

        return response()->json(['message' => 'CNPJ not found on external API'], 404);
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->validated();
        if (isset($data['address'])) {
            $address = $data['address'];
            $data['address'] = $address['street'] ?? null;
            $data['house_number'] = $address['house_number'] ?? null;
            $data['neighborhood'] = $address['neighborhood'] ?? null;
            $data['city'] = $address['city'] ?? null;
            $data['uf'] = $address['state'] ?? null;
        }
        $supplier = $this->supplierService->createSupplier($data);
        return response()->json($supplier, 201);
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        Log::info($request);
        $data = $request->validated();
        if (isset($data['address'])) {
            $address = $data['address'];
            $data['address'] = $address['street'] ?? null;
            $data['house_number'] = $address['house_number'] ?? null;
            $data['neighborhood'] = $address['neighborhood'] ?? null;
            $data['city'] = $address['city'] ?? null;
            $data['uf'] = $address['state'] ?? null;
        }
        $supplier = $this->supplierService->updateSupplier($id, $data);
        if ($supplier) {
            return response()->json($supplier);
        }
        return response()->json(['message' => 'Supplier not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->supplierService->deleteSupplier($id);
        if ($deleted) {
            return response()->json(['message' => 'Supplier deleted successfully']);
        }
        return response()->json(['message' => 'Supplier not found'], 404);
    }
}
