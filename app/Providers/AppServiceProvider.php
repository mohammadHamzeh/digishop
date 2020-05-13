<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Shop\Product;
use App\Models\User;
use App\Services\Storage\contracts\StorageInterface;
use App\Services\Storage\DatabaseStorage;
use App\Services\Storage\SessionStorage;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */             
    public function boot()
    {
        Relation::morphMap([
            'articles' => Article::class,
            'products' => Product::class,
            'users' => User::class,
            'categories' => Category::class
        ]);


        $settingJson = json_decode(Storage::disk('local')->get('settings.json'));
        View::share('panel_settings', $settingJson);
    }


}
