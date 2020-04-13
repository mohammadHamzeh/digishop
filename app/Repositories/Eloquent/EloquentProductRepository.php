<?php


namespace App\Repositories\Eloquent;


use App\Models\Shop\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepositoryInterface
{
    protected $model = Product::class;

}
