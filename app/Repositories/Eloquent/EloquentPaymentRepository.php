<?php


namespace App\Repositories\Eloquent;


use App\Models\Shop\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Eloquent\Contracts\EloquentBaseRepository;

class EloquentPaymentRepository extends EloquentBaseRepository implements PaymentRepositoryInterface
{

    protected $model = Payment::class;

    public static function paymentStatus()
    {
        return [
            'پرداخت شده' => self::PAID,
            'پرداخت نشده' => self::UNPAID
        ];
    }
}
