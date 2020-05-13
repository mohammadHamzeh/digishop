<?php


namespace App\Support\Costs;


use App\Support\Basket\Basket;
use App\Support\Costs\Contracts\CostInterface;

class BasketCost implements CostInterface
{
    /**
     * @var Basket
     */
    private $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function getCost()
    {
        return $this->basket->subTotal();
    }

    public function getTotalCost()
    {
        return $this->getCost();
    }

    public function persianDescription()
    {
        return 'سبد خرید';
    }

    public function getSummary()
    {
        return [$this->persianDescription() => $this->getCost()];
    }
}
