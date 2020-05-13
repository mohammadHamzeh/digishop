<?php

namespace App\Http\Controllers\AdminPanel\Shop;

use App\Filters\AdminPanel\OrderFilters;
use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->orderRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepository->filters(new OrderFilters())->with(['user', 'payment'])->paginate(config('paginate.per_page'));
        $orderStatus = $this->orderRepository::orderStatuses();
        return view('admin.orders.index', compact('orders', 'orderStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return void
     */
    public function show(Order $order)
    {
        $products = $order->products()->paginate(config('paginate.per_page'));
        return view('admin.orders.index_order', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus(Order $order)
    {
        $order->update(['status' => OrderRepositoryInterface::SUBMIT]);
        return response()->json([
            'success' => true
        ], 200);
    }
}
