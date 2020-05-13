<?php


namespace App\Repositories\Eloquent;


use App\Models\Shop\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentCartRepository extends EloquentBaseRepository implements CartRepositoryInterface
{
    protected $model = Cart::class;
}
