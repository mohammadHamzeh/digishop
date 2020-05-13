<?php

namespace App\Http\Controllers\AdminPanel\Shop;

use App\Filters\AdminPanel\PaymentFilter;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    protected $paymentRepository;

    /**
     * PaymentController constructor.
     * @param PaymentRepositoryInterface $repository
     */
    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->paymentRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = $this->paymentRepository->filters(new PaymentFilter())->paginate(config('paginate.per_page'));
        $paymentStatus = $this->paymentRepository::paymentStatus();
        return view('admin.payments.index', compact('payments','paymentStatus'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
