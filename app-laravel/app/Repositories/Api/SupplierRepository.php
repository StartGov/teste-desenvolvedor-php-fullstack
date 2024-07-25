<?php

namespace App\Repositories\Api;

use App\DTOS\Api\SupplierDTO;
use App\Interfaces\Api\ISupplierRepository;
use App\Models\Supplier;
use stdClass;

class SupplierRepository implements ISupplierRepository{
    public function __construct(
        protected Supplier $model,
    ) {}

    public function index() {
        $suppliers = $this->model->paginate(6);
        
        return $suppliers;
    }
    
    public function store(SupplierDTO $data): stdClass{
        $supplier = $this->model->create((array) $data);
        
        return (object) $supplier->toArray();
    }

    public function show(string $id): stdClass | null {
        $supplier = $this->model->find($id);
        
        return (object) $supplier->toArray();
    }
    
    public function update(string $id, SupplierDTO $data): stdClass | null {
        $supplier = $this->model->find($id);
        $supplier->update((array) $data);
        
        return (object) $supplier->toArray();
    }

    public function destroy(string $id): void {
        $supplier = $this->model->find($id);
        $supplier->destroy($id);
    }

    public function findOne(string $id): stdClass | null {
        $supplier = $this->model->find($id);

        return $supplier ?(object) $supplier->toArray() :null;
    }
}