<?php


namespace App\Presenter\AdminPanel;


use App\Models\Article;
use App\Presenter\contracts\Presenter;
use App\Repositories\Contracts\ArticleRepositoryInterface;

class ArticlePresenter extends Presenter
{
    public function status()
    {
        if ($this->object->status == ArticleRepositoryInterface::PUBLISHED) {
            return '<span class="badge badge-pill badge-success">منتشر شده</span>';
        }
        return '<span class="badge badge-pill badge-danger">پیش نویس</span>';
    }
}
