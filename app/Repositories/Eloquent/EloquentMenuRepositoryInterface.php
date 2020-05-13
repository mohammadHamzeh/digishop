<?php


namespace App\Repositories\Eloquent;


use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentMenuRepositoryInterface extends EloquentBaseRepository implements MenuRepositoryInterface
{
    protected $model = Menu::class;

    public function getMenuOrderBy($column, $orderBy)
    {
        return $this->model::orderBy($column, $orderBy)->orderBy('created_at', 'desc')->where('priority', '!=', '0')
            ->paginate(config
            ('paginate
    .per_page'));
    }

    public function IdTitles()
    {
        return $this->model::pluck('title', 'id')->toArray();
    }
}
