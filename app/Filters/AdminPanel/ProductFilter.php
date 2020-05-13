<?php


namespace App\Filters\AdminPanel;


use App\Filters\contracts\QueryFilter;

class ProductFilter extends QueryFilter
{
    public function search($value)
    {
        return $this->builder->where('title', 'LIKE', "%$value%");
    }

    public function status($value)
    {
        return $value == "all" ? $this->builder    : $this->builder->where('status', $value);
    }
    
}
