<?php


namespace App\Presenter\AdminPanel;


use App\Helpers\Currency\PersianCurrency;
use App\Helpers\Format\Number;
use App\Presenter\contracts\Presenter;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Morilog\Jalali\Jalalian;

class ProductPresenter extends Presenter
{
    public function price()
    {
        return PersianCurrency::toman($this->object->price);
    }

    public function status()
    {
        if ($this->object->status == ProductRepositoryInterface::PUBLISHED) {
            return '<span class="badge badge-pill badge-success">منتشر شده</span>';
        }
        return '<span class="badge badge-pill badge-warning">پیش نویس</span>';
    }

    public function stock()
    {
        return Number::persianNumbers($this->object->stock) . " عدد";
    }

    public function created_at()
    {
        return Number::persianNumbers(Jalalian::fromDateTime($this->object->created_at));
    }
}
