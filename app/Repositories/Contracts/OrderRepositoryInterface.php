<?php


namespace App\Repositories\Contracts;


interface OrderRepositoryInterface extends RepositoryInterface
{
    const REGISTERED = 1;
    const SUBMIT = 2;

    public static function orderStatuses();
}
