<?php


namespace App\Support\Discount;


use App\Models\Shop\Coupon;

class DiscountCalculator
{
    public function discountAmount(Coupon $coupon, $amount)
    {
        $discountAmount = (int)(($coupon->percent / 100) * $amount);
        return $this->isExceeded($coupon, $discountAmount) ? $coupon->limit : $discountAmount;
    }

    public function discountedPrice($coupon, $price)
    {
        return $price - $this->discountAmount($coupon, $price);
    }

    private function isExceeded(Coupon $coupon, int $discountAmount)
    {
        return $coupon->limit < $discountAmount;
    }
}
