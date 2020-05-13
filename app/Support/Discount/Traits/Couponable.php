<?php


namespace App\Support\Discount\Traits;


use App\Models\Shop\Coupon;
use Carbon\Carbon;

trait Couponable
{
    public function coupons()
    {
        return $this->morphMany(Coupon::class, 'couponable');
    }

    public function validCoupons()
    {
        return $this->coupons->where('expire_time', '>', Carbon::now());
    }
}
