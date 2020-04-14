<?php


namespace App\Repositories\Contracts;


interface ProductRepositoryInterface extends RepositoryInterface
{
    const PUBLISHED = 1;
    const DRAFT = 2;

    public function productStatuses();
}
