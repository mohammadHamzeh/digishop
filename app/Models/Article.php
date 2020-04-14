<?php

namespace App\Models;

use App\Filters\contracts\Filterable;
use App\Presenter\AdminPanel\ArticlePresenter;
use App\Presenter\contracts\Presentable;
use App\Traits\Categorizable;
use App\Traits\MetaTagable;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Taggable, MetaTagable, Categorizable, Presentable, Filterable;
    protected $presenter = ArticlePresenter::class;
    protected $fillable = [
        'title', 'description', 'author_id', 'view_count', 'status', 'image', 'slug', 'text'
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    public function editor()
    {
        return $this->belongsTo(Admin::class, 'editor_id');
    }
}
