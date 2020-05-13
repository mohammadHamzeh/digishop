@extends('admin.layouts.admin3')
@section('title')
    لیست منو ها
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
        <h6 class="h2 mb-0 mt-3">لیست منو ها</h6>
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">لیست منو ها</li>
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
                <div class="col-12 p-0 py-3 d-flex align-items-center justify-content-between">
                    @can('menu.add')
                        <a class="btn_add btn btn-success" href="{{url('admin/menus/create')}}"><i
                                    class="far fa-plus"></i> منو جدید </a>
                    @endcan

                    {{--                    <div class="d-flex">--}}
                    {{--                        <select class="form-control form-control-alternative w-auto" name="status">--}}
                    {{--                            <option value="all" selected>همه وضعیت ها</option>--}}
                    {{--                            @foreach($menuStatues as $key=>$value)--}}
                    {{--                                <option value="{{$key}}" {{@request('status') == $key ?'selected':''}}>--}}
                    {{--                                    {{$value}}--}}
                    {{--                                </option>--}}
                    {{--                            @endforeach--}}
                    {{--                        </select>--}}
                    {{--                    </div>--}}
                </div>
                <div class="table-responsive">
                    <div class="table-responsive pb-4">
                        <table class="table table-flush" id="datatable">
                            <thead class="thead-light">
                            <tr>
                                <th>اولویت</th>
                                <th>عنوان</th>
                                <th>والد</th>
                                <th>لینک</th>
                                <th>وضعیت</th>
                                <th>...</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($menus->currentpage() - 1) * $menus->perpage(); $i++; ?>
                            @foreach($menus as $menu)
                                <tr row-id="{{$menu->id}}">
                                    <td>{{\App\Helpers\Format\Number::persianNumbers($menu->priority)}}</td>
                                    <td>{{$menu->title}}</td>
                                    <td>{{optional($menu->parent)->title}}</td>
                                    <td>{{$menu->link}}</td>
                                    <td>
                                        {!!$menu->present()->status !!}
                                    </td>
                                    <td>
                                        @can('menu.edit') <a class="table-action text-info" data-toggle="tooltip"
                                                             data-original-title="ویرایش"
                                                             href="{{route('menus.edit',$menu->id)}}"><i
                                                    class="far fa-edit"></i></a> @endcan
                                        @can('menu.ban') <a class="table-action btn_ban text-warning"
                                                            data-toggle="tooltip" data-original-title="{{$menu->status?'پیش نویس
                                                               ':'منتشر'}}" row-id="{{$menu->id}}"><i class="far
                                                                {{$menu->status ==1?'fa-ban':'fa-check'}}"></i></a>
                                        @endcan
                                        @can('menu.delete') <a class="table-action btn_delete text-danger"
                                                               data-toggle="tooltip" data-original-title="حذف"
                                                               row-id="{{$menu->id}}"><i
                                                    class="far fa-trash-alt"></i></a> @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    @if(isset($search) && !empty($search))
                        {{$menus->appends(['search'=>$search])->links()}}
                    @else
                        {{$menus->links()}}
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
                "emptyTable": "منو ای  برای نمایش وجود ندارد.",
                "info": "نمایش _START_ تا _END_ ردیف (از _TOTAL_ رکورد)",
                "infoEmpty": "رکوردی یافت نشد."
            }
        });
        $('#key-search').on('keyup', function () {
            table.search(this.value).draw();
        });
        $('.navbar-search input').attr('placeholder', 'جستجو منو ها');

        $('.btn_delete').click(function () {
            var record_id = $(this).attr('row-id');
            var elm = $('.dataTable tr[row-id="' + record_id + '"]');
            Swal.fire({
                title: "",
                text: "منو انتخابی حذف شود؟",
                type: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: "btn btn-danger m-1",
                confirmButtonText: "بله",
                cancelButtonClass: "btn btn-secondary m-1",
                cancelButtonText: "خیر"
            }).then((result) => {
                if (result.value) {
                    load_screen(true);
                    $.ajax({
                        url: "{{url('admin/menus')}}/" + record_id,
                        type: "delete",
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        complete: function (response) {
                            load_screen(false);
                            response = JSON.parse(response.responseText);
                            if (response.success) {
                                table.row(elm).remove().draw();
                                Swal.fire({
                                    title: '',
                                    text: "منو انتخابی حذف شد.",
                                    type: "success",
                                    confirmButtonText: "خٌب",
                                    confirmButtonClass: "btn btn-outline-default",
                                    buttonsStyling: false
                                });
                            } else {
                                Swal.fire({
                                    title: '',
                                    text: response.error,
                                    type: "error",
                                    confirmButtonText: "خٌب",
                                    confirmButtonClass: "btn btn-outline-default",
                                    buttonsStyling: false
                                });
                            }
                        },
                        success: function (data) {
                        },
                        error: function (data) {
                            Swal.fire({title: data.responseText, type: "error", confirmButtonText: "خٌب"});
                        }
                    });
                }
            });
        });

        $('.btn_ban').click(function () {
            var btn = $(this);
            var record_id = $(this).attr('row-id');
            var elm = $('.dataTable tr[row-id="' + record_id + '"]');
            Swal.fire({
                title: "",
                text: "منو انتخابی " + btn.attr('data-original-title') + " شود؟",
                type: "question",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonClass: "btn btn-danger m-1",
                confirmButtonText: "بله",
                cancelButtonClass: "btn btn-secondary m-1",
                cancelButtonText: "خیر"
            }).then((result) => {
                if (result.value) {
                    load_screen(true);
                    $.ajax({
                        url: "{{url('admin/menus')}}/" + record_id + "/status",
                        type: "get",
                        dataType: "json",
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        complete: function (response) {
                            load_screen(false);
                            response = JSON.parse(response.responseText);
                            if (response.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    title: '',
                                    text: response.error,
                                    type: "error",
                                    confirmButtonText: "خٌب",
                                    confirmButtonClass: "btn btn-outline-default",
                                    buttonsStyling: false
                                });
                            }
                        },
                        success: function (data) {
                        },
                        error: function (data) {
                            Swal.fire({title: data.responseText, type: "error", confirmButtonText: "خٌب"});
                        }
                    });
                }
            });
        });
        $('select[name="status"]').change(function () {
            var status = $(this).val();

            var url = window.location.href + '?';
            window.location.href = url.slice(0, url.indexOf('?')) + '?status=' + status;
        });
    </script>
@endsection
