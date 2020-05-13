<?php

namespace App\Providers;

use App\Support\Basket\Basket;
use App\Support\Costs\BasketCost;
use App\Support\Costs\Contracts\CostInterface;
use App\Support\Costs\DiscountCost;
use App\Support\Costs\ShippingCost;
use App\Support\Discount\DiscountManager;
use Illuminate\Support\ServiceProvider;

class SummaryServiceProvider extends ServiceProvider
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
        $this->app->bind(CostInterface::class, function ($app) {
            $basketCost = new BasketCost($app->make(Basket::class));
            $shippingCost = new ShippingCost($basketCost);
            $discountCost = new DiscountCost($shippingCost, $app->make(DiscountManager::class));
            return $discountCost;
        });
    }
}
