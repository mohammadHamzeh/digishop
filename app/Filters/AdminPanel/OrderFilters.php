<?php


namespace App\Filters\AdminPanel;


use App\Filters\contracts\QueryFilter;

class OrderFilters extends QueryFilter
{
    public function status($value)
    {
        return $value == "all" ? $this->builder : $this->builder->where('status', $value);
    }


}
