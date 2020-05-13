<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['product_id', 'cart_id', 'quantity'];
    public $timestamps = false;

    public function carts()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
