<?php


namespace App\Filters\AdminPanel;


use App\Filters\contracts\QueryFilter;

class ArticleFilters extends QueryFilter
{
    public function search($value)
    {
        return $this->builder->where('title', 'LIKE', "%$value%")
            ->orWhereHas('creator', function ($query) use ($value) {
                $query->where('name', 'LIKE', "%$value%")->orWhere('family', 'LIKE', "%$value%");
            });
    }

    public function status($value)
    {
        return $this->builder->where('status', $value);
    }
}
