<?php


namespace App\Traits;


use App\Models\MetaTag;

trait MetaTagable
{
    public function meta_tag()
    {
        return $this->morphOne(MetaTag::class, 'metadata_for');
    }
}
