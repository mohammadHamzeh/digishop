<?php

namespace App\Models\Shop;

use App\Filters\contracts\Filterable;
use App\Models\User;
use App\Presenter\AdminPanel\OrderPresenter;
use App\Presenter\contracts\Presentable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Filterable, Presentable;

    protected $presenter = OrderPresenter::class;

    protected $fillable = [
        'user_id', 'code', 'amount', 'status'
    ];


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
