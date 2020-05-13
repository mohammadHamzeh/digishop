<?php


namespace App\Presenter\AdminPanel;


use App\Helpers\Currency\PersianCurrency;
use App\Helpers\Format\Number;
use App\Presenter\contracts\Presenter;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Morilog\Jalali\Jalalian;

class PaymentPresenter extends Presenter
{
    public function amount()
    {
        return PersianCurrency::toman($this->object->amount);
    }

    public function status()
    {
        if ($this->object->status == PaymentRepositoryInterface::PAID) {
            return '<span class="badge badge-pill badge-success">پرداخت شده</span>';
        }
        return '<span class="badge badge-pill badge-warning">پرداخت نشده</span>';
    }


    public function created_at()
    {
        return Number::persianNumbers(Jalalian::fromDateTime($this->object->created_at));
    }


}
