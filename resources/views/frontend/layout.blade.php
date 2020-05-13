<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap/bootstrap-rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawsome/releases/v0.0.0/css/pro.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

</head>
<body>

<div class="container">
    @inject('Presenter',App\Presenter\Frontend\LayoutPresenter)
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12 main-section">
            @if(session()->has('status'))
                <span class="alert alert-danger">
                    {{ Session()->get('status') }}
                </span>
            @endif
            @if(session()->has('success'))
                <span class="alert alert-success">
                    {{ Session()->get('success') }}
                </span>
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <span class="alert alert-danger">
                    {{ $error }}
                </span>
                @endforeach
            @endif
            <div class="dropdown">
                {!! $Presenter->ShowBasket() !!}
            </div>
            <div style="float: left">
                <button type="button" class="btn btn-success" style="font-family: IRANSans">
                    <a href="{{$Presenter->auth()['route']}}" style="color:
                                    white">{{$Presenter->auth()['name']}}</a>
                </button>
            </div>
        </div>
    </div>
    <div class="row search">
        <div class="col-lg-12 col-sm-12 main-section" style="padding-top: 15px">
            <div style="float: left">
            <form action="" method="get">
                <input type="text" style="border-radius: 2px" name="title">
                <button  style="border: none"><i class="fa fa-search" style="border: none"></i></button>
            </form>
        </div>
        </div>
    </div>
</div>

<div class="container page">

    @yield('content')
</div>

@yield('scripts')
<script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets3/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
