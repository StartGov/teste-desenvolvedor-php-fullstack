<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class UpdateController extends Controller
{

    public function __invoke(Request $request, Supplier $supplier)
    {

        $supplier->update($request->all());
    }
}
