<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;

class IndexController extends Controller
{

    public function __invoke()
    {
        $suppliers = Supplier::paginate();

        return SupplierResource::collection($suppliers);
    }
}
