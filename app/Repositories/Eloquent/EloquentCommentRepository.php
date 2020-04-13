<?php


namespace App\Repositories\Eloquent;


use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepositoryInterface
{
    protected $model = Comment::class;

}
