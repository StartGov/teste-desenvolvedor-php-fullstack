<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Services\SupplierService;

class SupplierController extends Controller
{
    
    public function index(Supplier $supplier)
    {
        return SupplierService::index($supplier);
    }
   
    public function store(SupplierRequest $request)
    {
        return SupplierService::store($request);
    }

    public function show($id)
    {
        return SupplierService::show($id);
    }

    public function update(SupplierUpdateRequest $request, $id)
    {
        return SupplierService::update($request, $id);
    }

    public function consultCnpj($cnpj)
    {
        return SupplierService::verifyCNPJ($cnpj);
    }


    public function destroy($id)
    {
        return SupplierService::destroy($id);
    }
}
