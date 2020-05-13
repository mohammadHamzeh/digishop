<?php


namespace App\Presenter\Frontend;


use App\Helpers\Currency\PersianCurrency;
use App\Helpers\Format\Number;
use App\Presenter\contracts\Presenter;

class BasketPresenter extends Presenter
{
    public function subTotal()
    {
        return PersianCurrency::toman($this->object->subTotal());
    }

}
