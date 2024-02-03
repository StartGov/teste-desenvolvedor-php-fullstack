<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Response;

class DeleteController extends Controller
{
    public function __invoke(Supplier $supplier): response
    {
        $supplier->forceDelete();

        return response()->noContent();
    }
}
