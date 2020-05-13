<?php


namespace App\Presenter\AdminPanel;


use App\Helpers\Currency\PersianCurrency;
use App\Helpers\Format\Number;
use App\Models\Article;
use App\Presenter\contracts\Presenter;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Morilog\Jalali\Jalalian;

class OrderPresenter extends Presenter
{
    public function status()
    {
        if ($this->object->status == OrderRepositoryInterface::REGISTERED) {
            return '<span class="badge badge-pill badge-default">ثبت شده</span>';
        }
        return '<span class="badge badge-pill badge-success">ارسال شده</span>';
    }

    public function amount()
    {
        return PersianCurrency::toman($this->object->amount);
    }

    public function created_at()
    {
        $date = \Morilog\Jalali\Jalalian::fromDateTime($this->object->created_at);
        return Number::persianNumbers($date) . '  - '
            . Number::persianNumbers($date->ago());
    }

}
