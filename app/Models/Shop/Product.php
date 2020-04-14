<?php

namespace App\Models\Shop;

use App\Filters\contracts\Filterable;
use App\Presenter\AdminPanel\ProductPresenter;
use App\Presenter\contracts\Presentable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Filterable, Presentable;
    protected $presenter = ProductPresenter::class;
    
    protected $fillable = [
        'title', 'description', 'price', 'stock', 'image', 'slug', 'text'
    ];
}
