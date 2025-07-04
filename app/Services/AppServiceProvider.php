<?php

use App\Interfaces\SupplierRepositoryInterface;
use App\Repositories\SupplierRepository;

$this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
