<?php

namespace App\Models\Shop;

use App\Filters\contracts\Filterable;
use App\Presenter\AdminPanel\PaymentPresenter;
use App\Presenter\contracts\Presentable;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Presentable, Filterable;

    protected $presenter = PaymentPresenter::class;

    protected $fillable = [
        'order_id', 'method', 'gateway', 'ref_num', 'amount', 'status', 'created_at', 'updated_at'
    ];
    protected $attributes = [
        'status' => PaymentRepositoryInterface::UNPAID,
        'ref_num' => null
    ];

    public function isOnline()
    {
        return $this->attributes['method'] == 'online';
    }

    public function confirm($refNum, $gateway)
    {
        $this->ref_num = $refNum;
        $this->gateway = $gateway;
        $this->status = PaymentRepositoryInterface::PAID;
        $this->save();
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
