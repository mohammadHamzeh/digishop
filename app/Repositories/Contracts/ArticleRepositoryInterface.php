<?php


namespace App\Repositories\Contracts;


interface ArticleRepositoryInterface extends RepositoryInterface 
{
    const PUBLISHED = 1;
    const DRAFT = 2;

    public function articleStatues(): array;
}
