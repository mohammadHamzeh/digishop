<?php


namespace App\Support\Discount;


use App\Support\Costs\BasketCost;

class DiscountManager
{
    /**
     * @var BasketCost
     */
    private $cost;
    private $discountCalculator;

    public function __construct(BasketCost $basketCost, DiscountCalculator $discountCalculator)
    {
        $this->cost = $basketCost;
        $this->discountCalculator = $discountCalculator;
    }

    public function calculateUserDiscount()
    {
        if (!session()->has('coupon')) return 0;

        return $this->discountCalculator->discountAmount(session()->get('coupon'), $this->cost->getTotalCost());
    }
}
