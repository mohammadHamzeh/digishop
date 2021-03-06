@extends('admin.layouts.admin3')
@section('title')
    لیست محصولات سفارش 
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('assets3/vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets3/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="header">
        <h6 class="h2 mb-0 mt-3">    لیست محصولات سفارش </h6>
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">   لیست محصولات
                                    سفارش
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body py-0 px-3">
                <div class="table-responsive">
                    <div class="table-responsive pb-4">
                        <table class="table table-flush" id="datatable">
                            <thead class="thead-light">
                            <tr>
                                <th>ردیف</th>
                                <th>محصول</th>
                                <th>قیمت</th>
                                <th>تعداد</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($products->currentpage() - 1) * $products->perpage(); $i++; ?>
                            @foreach($products as $product)
                                <tr row-id="{{$product->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->present()->price}}</td>
                                    <td>{{\App\Helpers\Format\Number::persianNumbers($product->pivot->quantity)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    @if(isset($search) && !empty($search))
                        {{$products->appends(['search'=>$search])->links()}}
                    @else
                        {{$products->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <script src="{{asset('assets3/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>
    <script>
        var table = $('#datatable').DataTable({
            paging: false, pageLength: 200,
            fixedHeader: true, responsive: true,
            "sDom": 'rtip',
            columnDefs: [{
                targets: 'no-sort', orderable: false
            }],
            "language": {
                "emptyTable": "محصول ای  برای نمایش وجود ندارد.",
                "info": "نمایش _START_ تا _END_ ردیف (از _TOTAL_ رکورد)",
                "infoEmpty": "رکوردی یافت نشد."
            }
        });
        $('#key-search').on('keyup', function () {
            table.search(this.value).draw();
        });
        $('.navbar-search input').attr('placeholder', 'جستجو محصولات');

        $('select[name="status"]').change(function () {
            var status = $(this).val();

            var url = window.location.href + '?';
            window.location.href = url.slice(0, url.indexOf('?')) + '?status=' + status;
        });
    </script>
@endsection
