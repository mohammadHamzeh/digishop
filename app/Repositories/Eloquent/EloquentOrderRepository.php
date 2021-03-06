<?php


namespace App\Repositories\Eloquent;


use App\Models\Shop\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepositoryInterface
{
    protected $model = Order::class;

    public static function orderStatuses()
    {
        return [
            'ثبت شده' => self::REGISTERED,
            'ارسال شده' => self::SUBMIT
        ];
    }
}
