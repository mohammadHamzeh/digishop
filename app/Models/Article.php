<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /*TODO ADD CONST */
    protected $fillable = [
        'title', 'description', 'author_id', 'view_count', 'status', 'image', 'slug'
    ];
}
