<?php


namespace App\Support\Payment;


use App\Events\OrderRegistered;
use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Support\Basket\Basket;
use App\Support\Payment\Gateway\Contracts\Pay;
use App\Support\Payment\Gateway\Pasargad;
use App\Support\Payment\Gateway\Saman;
use App\Support\Costs\Contracts\CostInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Transaction
{
    public $basket;
    public $request;
    private $paymentRepository;
    private $orderRepository;
    /**
     * @var CostInterface
     */
    private $cost;

    public function __construct(Basket $basket, Request $request, CostInterface $cost)
    {
        $this->basket = $basket;
        $this->request = $request;
        $this->cost = $cost;
        $this->paymentRepository = resolve(PaymentRepositoryInterface::class);
        $this->orderRepository = resolve(OrderRepositoryInterface::class);
    }

    public function checkout()
    {
        $order = $this->makeOrder();
        $payment = $this->makePayment($order);
        if ($payment->isOnline()) {
            return $this->gatewayFactory()->pay($order, $this->cost->getTotalCost());
        }
        $this->completeOrder($order);
        return $order;
    }

    public function verify()
    {
        $result = $this->gatewayFactory()->verify($this->request);
        if ($result['status'] === Pay::TRANSACTION_FAILED) return false;
        $result['order']->payment->confirm($result['refNum'], $result['gateway']);
        $this->completeOrder($result['order']);
        return true;
    }

    private function makePayment(Order $order): Payment
    {
        return $this->paymentRepository->store([
            'order_id' => $order->id,
            'method' => $this->request->input('method'),
            'amount' => $this->cost->getTotalCost(),
        ]);
    }

    private function makeOrder(): Order
    {
        $order = $this->orderRepository->store([
            'user_id' => $this->request->user()->id,
            'code' => bin2hex(Str::random(16)),
            'amount' => $this->basket->subTotal(),
        ]);
        $order->products()->attach($this->products());
        return $order;
    }

    private function products()
    {
        foreach ($this->basket->all() as $product) {
            $products[$product->id] = ['quantity' => $product->quantity];
        }
        return $products;
    }

    private function completeOrder(Order $order)
    {
        event(new OrderRegistered($order));
        $this->normalizeStock($order);
        $this->basket->clear();
        session()->forget('coupon');
    }

    private function normalizeStock(Order $order)
    {
        foreach ($order->products as $product) {
            return $product->decrementStock($product->pivot->quantity);
        }
    }

    private function gatewayFactory()
    {
        $gateways = [
            'saman' => Saman::class,
            'pasargad' => Pasargad::class
        ][$this->request->gateway];
        return resolve($gateways);
    }
}
