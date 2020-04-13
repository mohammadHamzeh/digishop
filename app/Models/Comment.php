<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /*todo add conts*/

    protected $fillable = [
        'user_id', 'admin_id', 'body', 'parent_id', 'status', 'commentable_id', 'commentable_type'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}

