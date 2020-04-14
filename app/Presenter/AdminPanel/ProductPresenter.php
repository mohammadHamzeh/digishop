<?php


namespace App\Presenter\AdminPanel;


use App\Presenter\contracts\Presenter;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductPresenter extends Presenter
{
    public function price()
    {
        return number_format($this->price) . ' ' . 'تومان';
    }

    public function status()
    {
        if ($this->object->status == ProductRepositoryInterface::PUBLISHED) {
            return '<span class="badge badge-pill badge-success">منتشر شده</span>';
        }
        return '<span class="badge badge-pill badge-danger">پیش نویس</span>';
    }
}
