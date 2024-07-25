<?php

namespace App\Providers;

use App\Interfaces\Api\ISupplierRepository;
use App\Interfaces\Api\ISupplierService;
use App\Repositories\Api\SupplierRepository;
use App\Services\Api\SupplierService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ISupplierService::class, SupplierService::class);
        $this->app->bind(ISupplierRepository::class, SupplierRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}