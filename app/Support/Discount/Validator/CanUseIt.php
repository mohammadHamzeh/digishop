<?php


namespace App\Support\Discount\Validator;


use App\Models\Shop\Coupon;
use App\Support\Discount\Validator\contracts\AbstractCouponValidator;
use App\Support\Discount\Validator\Exceptions\IllegalCouponException;

class CanUseIt extends AbstractCouponValidator
{
    public function validate(Coupon $coupon)
    {
        if (!auth()->user()->coupons->contains($coupon)) {
            throw new IllegalCouponException();
        }
        return parent::validate($coupon);
    }
}
