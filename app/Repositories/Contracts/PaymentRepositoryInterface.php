<?php


namespace App\Repositories\Contracts;


interface PaymentRepositoryInterface extends RepositoryInterface
{
    const PAID = 1;
    const UNPAID = 2;

    public static function paymentStatus();
}
