<?php

namespace App\Providers;

use App\Repositories\Interfaces\SellerRepositoryInterface;
use App\Repositories\OfferRepositoryEloquent;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Repositories\SellerRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OfferRepositoryInterface::class, OfferRepositoryEloquent::class);
        $this->app->bind(SellerRepositoryInterface::class, SellerRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
