<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\Contracts\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    protected $model;

    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $address = $this->model->find($id);
        if ($address) {
            $address->update($data);
            return $address;
        }
        return null;
    }

    public function delete($id)
    {
        $address = $this->model->find($id);
        if ($address) {
            $address->delete();
            return true;
        }
        return false;
    }
}
