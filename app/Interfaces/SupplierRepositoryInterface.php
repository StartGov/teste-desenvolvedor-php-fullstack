<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    public function all(Request $request);
    public function find(int $id): ?Supplier;
    public function create(array $data): Supplier;
    public function update(Supplier $supplier, array $data): Supplier;
    public function delete(Supplier $supplier): bool;
}
