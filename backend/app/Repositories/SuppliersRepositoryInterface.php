<?php

namespace App\Repositories;

interface SuppliersRepositoryInterface
{
    public function create($data);
    public function findById($id);
    public function update($data, $id);
    public function delete($id);
    public function getPaginate($filters, $perPage);
}
