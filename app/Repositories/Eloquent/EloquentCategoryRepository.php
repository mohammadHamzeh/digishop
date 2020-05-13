<?php


namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;

    public function IdTitles()
    {
        return $this->model::pluck('title', 'id')->toArray();
    }
}
