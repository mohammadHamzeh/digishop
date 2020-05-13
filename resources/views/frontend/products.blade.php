@extends('frontend.layout')

@section('title', 'Products')

@section('content')

    <div class="container products" style="direction: rtl">

        <div class="row">

            @foreach($products as $product)
                <div class="col-xs-18 col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="https://cdn.vox-cdn.com/thumbor/309v_5GNMQnzola5LtOpFjB7w4w=/0x0:3960x2640/1200x800/filters:focal(1664x1004:2296x1636)/cdn.vox-cdn.com/uploads/chorus_image/image/58464691/samsunggalaxys9leak.1516980557.jpg"
                             alt="">

                        <div class="caption" style="font-family: IRANSans">

                            <h5>{{$product->title}}</h5>

                            <p>{{substr($product->description, 50)}}</p>
                            <p><strong>قیمت:</strong> {{$product->present()->price}}</p>
                            <p class="btn-holder">
                                <a href="{{route('basket.add',$product->id)}}" class="btn btn-warning btn-block
                            text-center" role="button">اضافه به سبد
                                    خرید</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>

    </div><!-- End row -->
    <div class="row align-content-center"> {{$products->links() }}
    </div>


@endsection
