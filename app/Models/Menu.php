<?php

namespace App\Models;

use App\Presenter\AdminPanel\MenuPresenter;
use App\Presenter\contracts\Presentable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Presentable;
    protected $fillable = ['title', 'parent_id', 'status', 'priority', 'link'];

    protected $presenter = MenuPresenter::class;

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }
}
