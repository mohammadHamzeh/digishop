@extends('frontend.layout')
@section('content')

    <div class="row justify-content-between" style="direction: rtl; margin-bottom: 30px">
        <div class="col-6">
            <div class="form-control" style="padding: 3px; font-family: IRANSans">
                <label class="form-control-label" for="method" style="font-family: IRANSans; padding: 3px">آدرس تحویل
                    سفارش</label>
                <p> {{auth()->user()->address}}</p>
                <p><i class="fad fa-phone" style="font-size: 12px"></i>
                    {{\App\Helpers\Format\Number::persianNumbers(auth()->user()->phone)
                }}</p>
                <p><i class="fad fa-user" style="font-size: 12px"></i>
                    {{auth()->user()->full_name }}</p>
            </div>
        </div>
        <div class="col-6">
            @if(session()->has('coupon'))
                <form class="form-control" action="{{route('coupon.remove')}}" method="get">
                    @csrf
                    <div class="input-group">
                        <label class="form-control-label" for="coupon" style="font-family: IRANSans">کد تخفیف:</label>
                        <span id="coupon" style="margin-right: 15px;font-family: IRANSans;">{{session()->get('coupon')
                        ->code}}</span>
                        <button class="btn btn-primary btn-block" type="submit">حذف کد تخفیف</button>
                    </div>
                </form>
            @else
                <form class="form-control" id="formDiscount" action="{{route('checkCoupon')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-control-label" for="method" style="font-family: IRANSans">کد تخفیف</label>
                        <input class="form-control" type="text" name="coupon" id="coupon">
                    </div>
                    <button class="btn btn-danger btn-block" type="submit" style="font-family: IRANSans">ثبت کد تخفیف
                    </button>
                </form>
            @endif

        </div>

    </div>
    <div class="row justify-content-between" style="direction: rtl">
        <div class="col-6">
            @include('frontend.partials.summary')
        </div>
        <div class="col-6">
            <form class="form-control" action="{{route('basket.checkout')}}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-control-label" for="method" style="font-family: IRANSans">روش پرداخت</label>
                    <select class="form-control form-control-alternative" name="method" id="method">
                        <option value="online">آنلاین</option>
                        <option value="cart">کارت به کارت</option>
                        <option value="offline">آفلاین</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="method" style="font-family: IRANSans">درگاه پرداخت</label>
                    <select class="form form-control" name="gateway" id="method">
                        <option value="saman">سامان</option>
                        <option value="pasargad">پاسارگاد</option>
                    </select>
                </div>
                <button class="btn btn-success btn-block" type="submit" style="font-family: IRANSans">ادامه
                    پرداخت
                </button>
            </form>
        </div>

    </div>

@endsection
@section('scripts')

    {{--    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>--}}
    {{--    <script>--}}
    {{--        $('#formDiscount').on('submit', function (event) {--}}
    {{--            event.preventDefault();--}}
    {{--            discount_name = $('#discount_code').val();--}}
    {{--            $.ajax({--}}
    {{--                url: "{{route('checkDiscount')}}",--}}
    {{--                type: "POST",--}}
    {{--                data: {--}}
    {{--                    "_token": "{{ csrf_token() }}",--}}
    {{--                    discount_name: discount_name,--}}
    {{--                },--}}
    {{--                success: function (response) {--}}
    {{--                    console.log(response);--}}
    {{--                },--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
