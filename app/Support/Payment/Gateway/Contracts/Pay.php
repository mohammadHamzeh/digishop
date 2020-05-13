<?php


namespace App\Support\Payment\Gateway\Contracts;


use App\Models\Shop\Order;
use Illuminate\Http\Request;

interface Pay
{
    const TRANSACTION_SUCCESS = "transaction.success";
    const TRANSACTION_FAILED = "transaction.failed";

    public function pay(Order $order, int $amount);

    public function verify(Request $request);

    public function getName(): string;
}
