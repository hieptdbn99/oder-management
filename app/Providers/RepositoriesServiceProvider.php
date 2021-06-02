<?php

namespace App\Providers;

use App\Product;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(OrderInterface::class,OrderRepository::class);
        $this->app->bind(ProductInterface::class,ProductRepository::class);
    }
}
