<?php


namespace App\Repositories\Contracts;


interface CouponRepositoryInterface extends RepositoryInterface
{
    public function isExpired();
}
