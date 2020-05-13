<?php


namespace App\Support\Costs;


use App\Support\Costs\Contracts\CostInterface;

class ShippingCost implements CostInterface
{
    /**
     * @var CostInterface
     */
    private $cost;

    const SHIPPING_COST = 20000;

    public function __construct(CostInterface $cost)
    {
        $this->cost = $cost;
    }

    public function getCost()
    {
        return self::SHIPPING_COST;
    }

    public function getTotalCost()
    {
        return $this->getCost() + $this->cost->getTotalCost();
    }

    public function persianDescription()
    {
        return "هزینه حمل و نقل";
    }

    public function getSummary()
    {
        return array_merge($this->cost->getSummary(), [$this->persianDescription() => $this->getCost()]);
    }
}
