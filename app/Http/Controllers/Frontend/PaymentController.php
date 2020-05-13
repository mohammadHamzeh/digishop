<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\Payment\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function verify(Request $request)
    {
        $result = $this->transaction->verify();
        return $result ? $this->successResponse() : $this->errorResponse();
    }

    private function successResponse()
    {
        return redirect()->route('products')->with('success', 'سفارش شما با موفقیت ایجاد شد');
    }

    private function errorResponse()
    {
        return redirect()->route('products')->with('status', 'مشکلی در هنگام ثبت سفارش به وجود آمده است');
    }
}
