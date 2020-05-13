<?php


namespace App\Repositories\Contracts;


interface MenuRepositoryInterface extends RepositoryInterface
{
    public function getMenuOrderBy($column, $orderBy);

    public function IdTitles();

}
