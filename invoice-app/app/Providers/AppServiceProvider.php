<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );

        $this->app->bind(
            \App\Interfaces\ContractRepositoryInterface::class,
            \App\Repositories\ContractRepository::class
        );

        $this->app->bind(
            \App\Interfaces\InvoiceRepositoryInterface::class,
            \App\Repositories\InvoiceRepository::class
        );

        // laravel doc reference: https://laravel.com/docs/10.x/container#binding-typed-variadics
        // dependency injects an array with concrete class names when needed
        $this->app->singleton(\App\Services\TaxService::class, function (Application $app) {
            return new \App\Services\TaxService(
                $app->make(\App\Actions\TaxCalculators\VATTaxCalculator::class),
                $app->make(\App\Actions\TaxCalculators\MunicipalFeeTaxCalculator::class),
            );
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ex: binding observers 
    }
}
