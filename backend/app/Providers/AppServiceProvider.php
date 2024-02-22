<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SuppliersRepositoryInterface;
use App\Repositories\Implements\SuppliersRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SuppliersRepositoryInterface::class, function ($app) {
            return new SuppliersRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
