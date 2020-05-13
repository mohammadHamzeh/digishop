<?php


namespace App\Support\Costs;


use App\Support\Costs\Contracts\CostInterface;
use App\Support\Discount\DiscountManager;

class DiscountCost implements CostInterface
{
    /**
     * @var DiscountManager
     */
    private $discountManager;
    /**
     * @var CostInterface
     */
    private $cost;

    public function __construct(CostInterface $cost, DiscountManager $discountManager)
    {
        $this->cost = $cost;
        $this->discountManager = $discountManager;
    }

    public function getCost()
    {
        return $this->discountManager->calculateUserDiscount();
    }

    public function getTotalCost()
    {
        return $this->cost->getTotalCost() - $this->getCost();
    }

    public function persianDescription()
    {
        return 'تخفیف';
    }

    public function getSummary()
    {
        return array_merge($this->cost->getSummary(), [$this->persianDescription() => $this->getCost()]);
    }
}
