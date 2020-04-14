<?php


namespace App\Filters\contracts;


trait Filterable
{
    public function scopeFilters($query, QueryFilter $queryFilter)
    {
        return $queryFilter->apply($query);
    }
}
