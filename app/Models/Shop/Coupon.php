<?php

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'percent', 'expire_time', 'couponable_id', 'couponable_type', 'limit'];

    public function isExpired()
    {
        return Carbon::now()->isAfter(Carbon::parse($this->expire_time));
    }
}
