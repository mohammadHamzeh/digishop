<?php


namespace App\Repositories\Eloquent;


use App\Models\Shop\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentCouponRepository extends EloquentBaseRepository implements CouponRepositoryInterface
{
    protected $model = Coupon::class;

    public function isExpired()
    {

    }
}
