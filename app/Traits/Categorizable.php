<?php


namespace App\Traits;


use App\Models\Category;

trait Categorizable
{
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');

    }
}
