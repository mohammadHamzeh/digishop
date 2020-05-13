<?php


namespace App\Filters\Frontend;


use App\Filters\contracts\QueryFilter;

class ProductFilters extends QueryFilter
{
    public function title($value)
    {
        return $this->builder->where('title', "LIKE", "%$value%");
    }
}
