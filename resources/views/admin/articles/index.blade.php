@extends('admin.layouts.admin3')
@section('title')
    لیست مقالات
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
        <h6 class="h2 mb-0 mt-3">لیست مقالات</h6>
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">لیست مقالات</li>
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
                    @can('article.add')
                        <a class="btn_add btn btn-success" href="{{url('admin/articles/create')}}"><i
                                    class="far fa-plus"></i> مقاله جدید </a>
                    @endcan

                    <div class="d-flex">
                        <select class="form-control form-control-alternative w-auto" name="status">
                            <option value="" selected>همه وضعیت ها</option>
                            @foreach($articleStatues as $key=>$value)
                                <option value="{{$key}}" {{@request('status') == $key ?'selected':''}}>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="table-responsive pb-4">
                        <table class="table table-flush" id="datatable">
                            <thead class="thead-light">
                            <tr>
                                <th>ردیف</th>
                                <th>مقاله</th>
                                <th>نویسنده</th>
                                <th>زمان ثبت</th>
                                <th>وضعیت</th>
                                <th>...</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($articles->currentpage() - 1) * $articles->perpage(); $i++; ?>
                            @foreach($articles as $article)
                                <tr row-id="{{$article->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->creator->fullname}}</td>
                                    <td>{{\Morilog\Jalali\Jalalian::fromDateTime($article->created_at)}}</td>
                                    <td>
                                        {!!$article->present()->status !!}
                                    </td>
                                    <td>
                                        @can('article.edit') <a class="table-action text-info" data-toggle="tooltip"
                                                                data-original-title="ویرایش"
                                                                href="{{url('admin/articles/'.$article->id.'/edit')}}"><i
                                                    class="far fa-edit"></i></a> @endcan
                                        {{--                                        @can('article.ban') <a class="table-action btn_ban text-warning"--}}
                                        {{--                                                               data-toggle="tooltip"--}}
                                        {{--                                                               data-original-title="{{$article->disabled?'فعال':'مسدود'}}"--}}
                                        {{--                                                               row-id="{{$article->id}}"><i--}}
                                        {{--                                                    class="far {{$article->disabled?'fa-check':'fa-ban'}}"></i></a> @endcan--}}
                                        @can('article.delete') <a class="table-action btn_delete text-danger"
                                                                  data-toggle="tooltip" data-original-title="حذف"
                                                                  row-id="{{$article->id}}"><i
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
                        {{$articles->appends(['search'=>$search])->links()}}
                    @else
                        {{$articles->links()}}
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
                "emptyTable": "مقاله ای  برای نمایش وجود ندارد.",
                "info": "نمایش _START_ تا _END_ ردیف (از _TOTAL_ رکورد)",
                "infoEmpty": "رکوردی یافت نشد."
            }
        });
        $('#key-search').on('keyup', function () {
            table.search(this.value).draw();
        });
        $('.navbar-search input').attr('placeholder', 'جستجو مقالات');

        $('.btn_delete').click(function () {
            var record_id = $(this).attr('row-id');
            var elm = $('.dataTable tr[row-id="' + record_id + '"]');
            Swal.fire({
                title: "",
                text: "مقاله انتخابی حذف شود؟",
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
                        url: "{{url('admin/articles')}}/" + record_id,
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
                                    text: "مقاله انتخابی حذف شد.",
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
                text: "مقاله انتخابی " + btn.attr('data-original-title') + " شود؟",
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
                        url: "{{url('admin/articles')}}/" + record_id + "/edit?action=ban",
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
                                switch (response.state) {
                                    case 0:
                                        elm.children('td:nth-child(' + (elm.children('td').length - 1) + ')').find('.badge[ban]').removeClass('badge-danger').addClass('badge-success').text('فعال');
                                        btn.attr('data-original-title', 'مسدود').find('i').removeClass('fa-check').addClass('fa-ban');
                                        break;
                                    case 1:
                                        elm.children('td:nth-child(' + (elm.children('td').length - 1) + ')').find('.badge[ban]').removeClass('badge-info').addClass('badge-danger').text('مسدود');
                                        btn.attr('data-original-title', 'فعال').find('i').removeClass('fa-ban').addClass('fa-check');
                                        break;
                                }
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
