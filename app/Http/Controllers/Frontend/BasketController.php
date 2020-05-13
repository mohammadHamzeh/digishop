<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Basket\QuantityExeededException;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;

use App\Support\Basket\Basket;
use App\Support\Payment\Transaction;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    private $basket;
    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(Basket $basket, Transaction $transaction)
    {
        $this->middleware('auth')->only(['checkoutForm', 'checkout']);
        $this->basket = $basket;
        $this->transaction = $transaction;
    }

    public function index()
    {
        $items = $this->basket->all();
        return view('frontend.cart', compact('items'));
    }

    public function add(Product $product)
    {
        try {
            $this->basket->add($product, 1);
            return back()->with('success', 'محصول با موفقیت به سبد خرید اضافه شد');
        } catch (QuantityExeededException $e) {
            return back()->with('status', 'محصول به این تعداد در انبار موجود نمی باشد');
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $this->basket->update($product, $request->quantity);
            return back()->with('success', 'محصول با موفقیت افزوده شد');
        } catch (QuantityExeededException $e) {
            return back()->with('status', 'محصول به این تعداد در انبار موجود نمی باشد');
        }
    }

    public function checkoutForm()
    {
        return view('frontend.checkout');
    }

    public function checkout()
    {
        $order = $this->transaction->checkout();
        return redirect()->route('products')->with('success', __('سفارش شما با موفقیت ثبت شد', ['orderNum' =>
            $order->id]));
    }
}
