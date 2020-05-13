<?php

namespace App\Models;

use App\Support\Discount\Traits\Couponable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Couponable;
    protected $fillable = [
        'title', 'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
