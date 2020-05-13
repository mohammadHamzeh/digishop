@extends('frontend.layout')@section('title', 'Cart')@inject('basket',App\Support\Basket\Basket)

@section('content')
    @if($items->isEmpty())
        <span class="badge badge-warning " style="font-family: IRANSans;font-size: 18px">سبد خرید شما خالی است
            برای
            ادامه
            خرید <a href="{{route('products')
        }}">اینجا</a>کنید
            </span>
    @else
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:50%">محصول</th>
                <th style="width:10%">قیمت</th>
                <th style="width:8%">تعداد</th>
                <th style="width:22%" class="text-center">جمع خرید</th>
                <th style="width:10%"></th>
            </tr>
            </thead>
            <tbody>

            @foreach($items  as $item)
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $item->title }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $item->present()->price }}</td>
                    <td data-th="Quantity">
                        <form action="{{route('basket.update',$item->id)}}" method="post">
                            @csrf
                            <select name="quantity" id="quantity">
                                @for($i=0;$i<=$item->stock ;$i++)
                                    <option {{$item->quantity ==$i ?'selected':''}} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <button type="submit" class="badge-success">update</button>
                        </form>
                    </td>
                    <td data-th="Subtotal" class="text-center">
                        {{ \App\Helpers\Currency\PersianCurrency::toman($item->price * $item->quantity) }}
                    </td>

                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>مجموع خرید {{$basket->present()->subTotal }}</strong></td>
            </tr>
            <tr>
                <td><a href="{{ route('products') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> ادامه
                        خرید از
                        سایت
                    </a>
                <td><a href="{{route('basket.checkoutForm')}}" class="btn btn-success"><i class="fa fa-angle-left"></i>ثبت
                        و ادامه سفارش</a>
            </tfoot>
        </table>
    @endif
@endsection
@section('scripts')
@endsection
