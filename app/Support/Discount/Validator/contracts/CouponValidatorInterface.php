<?php


namespace App\Support\Discount\Validator\contracts;


use App\Models\Shop\Coupon;

interface CouponValidatorInterface
{
    public function setNextValidator(CouponValidatorInterface $validator);
    public function validate(Coupon $coupon);
}
