<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Supplier $supplier): SupplierResource
    {

        $supplier->update($request->all());

        return SupplierResource::make($supplier);
    }
}
