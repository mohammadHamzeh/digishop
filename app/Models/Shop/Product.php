<?php

namespace App\Models\Shop;

use App\Filters\contracts\Filterable;
use App\Presenter\AdminPanel\ProductPresenter;
use App\Presenter\contracts\Presentable;
use App\Support\Discount\DiscountCalculator;
use App\Support\Discount\Traits\Couponable;
use App\Traits\Categorizable;
use App\Traits\Commentable;
use App\Traits\MetaTagable;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Filterable, Presentable, Taggable, Categorizable, MetaTagable, Couponable,Commentable;
    protected $presenter = ProductPresenter::class;

    protected $fillable = [
        'title', 'description', 'price', 'stock', 'image', 'slug', 'text', 'status'
    ];

    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    public function orders()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function decrementStock($quantity)
    {
        return $this->decrement('stock', $quantity);
    }

    public function getPriceAttribute($price)
    {
        $categories = $this->categories;
        if ($categories->isNotEmpty()) {
            foreach ($categories as $category) {
                $coupon = $category->validCoupons()->first();
                if (!is_null($coupon)) {
                    $discountCalculator = resolve(DiscountCalculator::class);
                    return $discountCalculator->discountedPrice($coupon, $price);
                }
            }
        }
        return $price;
    }
}
