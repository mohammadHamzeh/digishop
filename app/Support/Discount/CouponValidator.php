<?php


namespace App\Support\Discount;


use App\Models\Shop\Coupon;
use App\Support\Discount\Validator\CanUseIt;
use App\Support\Discount\Validator\IsExpired;

class CouponValidator
{
    public function isValid(Coupon $coupon)
    {
        $canUseIt = resolve(CanUseIt::class);
        $isExpired = resolve(IsExpired::class);

        $isExpired->setNextValidator($canUseIt);

        return $isExpired->validate($coupon);
    }
}
