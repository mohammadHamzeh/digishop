<?php


namespace App\Repositories\Eloquent;


use App\Models\MetaTag;
use App\Repositories\Contracts\MetaTagRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentMetaTagRepository extends EloquentBaseRepository implements MetaTagRepositoryInterface
{
    protected $model = MetaTag::class;
}
