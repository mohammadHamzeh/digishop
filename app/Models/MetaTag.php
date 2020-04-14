<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'keyword', 'author', 'metadata_for_type', 'metadata_for_id'
    ];
    protected $table = 'meta_datas';

    public function meta_tag_able()
    {
        return $this->morphTo();
    }
}
