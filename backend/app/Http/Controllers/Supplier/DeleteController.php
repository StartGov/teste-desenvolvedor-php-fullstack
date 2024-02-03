<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    public function __invoke(Supplier $supplier)
    {
        $supplier->forceDelete();

        return response()->noContent();
    }
}
