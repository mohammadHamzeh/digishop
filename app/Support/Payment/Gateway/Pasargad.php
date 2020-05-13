<?php


namespace App\Support\Payment\Gateway;


use App\Models\Shop\Order;
use App\Support\Payment\Gateway\Contracts\Pay;
use Illuminate\Http\Request;

class Pasargad implements Pay
{
    public function pay(Order $order)
    {
        // TODO: Implement pay() method.
    }

    public function verify(Request $request)
    {
        // TODO: Implement verify() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }
}
