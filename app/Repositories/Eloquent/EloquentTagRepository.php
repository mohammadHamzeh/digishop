<?php


namespace App\Repositories\Eloquent;


use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentTagRepository extends EloquentBaseRepository implements TagRepositoryInterface
{
    protected $model = Tag::class;

}
