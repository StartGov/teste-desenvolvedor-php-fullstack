<?php

namespace App\Interfaces\Api;

use App\DTOS\Api\SupplierDTO;
use stdClass;

interface ISupplierService {
    public function index();
    public function store(SupplierDTO $data): stdClass;
    public function show(string $id): stdClass | null;
    public function update(string $id, SupplierDTO $data): stdClass | null;
    public function destroy(string $id): void;
}