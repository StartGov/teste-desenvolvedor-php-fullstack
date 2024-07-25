<?php

namespace App\Repositories;

use App\Models\Provider;
use App\Repositories\Contracts\ProviderRepositoryInterface;

class ProviderRepository implements ProviderRepositoryInterface
{
    protected $model;

    public function __construct(Provider $model)
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
        $provider = $this->model->find($id);
        if ($provider) {
            $provider->update($data);
            return $provider;
        }
        return null;
    }

    public function delete($id)
    {
        $provider = $this->model->find($id);
        if ($provider) {
            $provider->delete();
            return true;
        }
        return false;
    }

    public function paginate($perPage, $search = '', $sortField = 'id', $sortDirection = 'DESC')
    {
        $query = $this->model->with('address');

        $query->where('company_name', 'like', '%' . $search . '%')
        ->orWhere('document_number', 'like', '%' . $search . '%');

        $query->orderBy($sortField, $sortDirection);

        $pagination = $query->paginate($perPage);

        return [
            'data' => $pagination->items(),
            'meta' => [
                'page' => $pagination->currentPage(),
                'per_page' => $pagination->perPage(),
                'last_page' => $pagination->lastPage(),
                'total_items' => $pagination->total(),
            ]
        ];
    }
}
