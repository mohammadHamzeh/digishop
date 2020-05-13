<?php

namespace App\Providers;


use App\Support\Storage\contracts\StorageInterface;
use App\Support\Storage\SessionStorage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //        $this->app->singleton(StorageInterface::class, function ($app) {
        //            return new DatabaseStorage();
        //        });
        $this->app->singleton(StorageInterface::class, function ($app, $parameter) {
            return new SessionStorage('Basket');
        });
    }
}
