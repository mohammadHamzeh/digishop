<?php


namespace App\Repositories\Eloquent;


use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentArticleRepository   extends EloquentBaseRepository implements ArticleRepositoryInterface
{
    protected $model = Article::class;

    public function articleStatues(): array
    {
        return [
            self::PUBLISHED => 'منتشر شده',
            self::DRAFT => 'پیش نویس',
        ];
    }
}
