@extends('admin.layouts.admin3')
@section('title')
    منو جدید
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
@endsection

@section('content')
    <div class="header">
        <h6 class="h2 mb-0 mt-3">منو جدید</h6>
        <div class="header-body">
            <div class="col-12 py-4">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/menus')}}">لیست منو ها</a></li>
                        <li class="breadcrumb-item active" aria-current="page">منو جدید</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-gradient-secondary shadow">
            <div class="card-body">
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">عنوان <i class="fas fa-star-of-life text-red"
                                                                   style="font-size:8px;"></i></label>
                        <input type="text" class="form-control form-control-alternative" name="title"
                               placeholder="مثلا: صفحه اصلی">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-6">
                        <label class="form-control-label">والد
                            <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                        <select name="parent" id="parent" class="form-control">
                            <option value="null">بدون والد</option>
                            @foreach($menus as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-control-label">اولویت
                            <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                        <input type="number" name="priority" class="form-control" placeholder="مثلا: 1">
                    </div>
                    <div class="col-3">
                        <label class="form-control-label">وضعیت
                            <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">غیر فعال</option>
                            <option value="1">فعال</option>
                        </select>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">لینک
                            <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                        <input type="text" name="link" class="form-control" placeholder="{{env('APP_URL')
                        }}/test">
                    </div>
                </div>
            </div>
            <div class="card-footer">

                <button class="btn btn-success btn-air btn_add_confirm font-20" type="button">افزودن <i
                            class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script src="{{asset('assets3/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>

    <script>
        $('.navbar-search').remove();

        $('.note-editor button').removeClass('btn-default');

        var form_data = new FormData();

        $('.btn_add_confirm').click(function () {
            var title = $('.card-body input[name="title"]').val();
            var parent = $('.card-body select[name="parent"]').val();
            var status = $('.card-body select[name="status"]').val();
            var link = $('.card-body input[name="link"]').val();
            var priority = $('.card-body input[name="priority"]').val();

            if (title != "") {
                form_data.append('_token', $('meta[name=csrf-token]').attr('content'));
                form_data.append('title', title);
                form_data.append('parent', parent);
                form_data.append('status', status);
                form_data.append('link', link);
                form_data.append('priority', priority);
                load_screen(true);
                $.ajax({
                    url: "{{url('admin/menus')}}",
                    type: "post",
                    data: form_data,
                    dataType: "text",
                    cache: false,
                    contentType: false,
                    processData: false,
                    complete: function (response) {
                        load_screen(false);
                        response = JSON.parse(response.responseText);
                        if (response.success) {
                            window.location.href = "{{url()->previous()}}";
                        } else {
                            if (response.error.title) {
                                Swal.fire({
                                    title: '',
                                    text: response.error.title,
                                    type: "error",
                                    confirmButtonText: "خٌب",
                                    confirmButtonClass: "btn btn-outline-default",
                                    buttonsStyling: false
                                });
                            }
                            if (response.error.desc) {
                                Swal.fire({
                                    title: '',
                                    text: response.error.desc,
                                    type: "error",
                                    confirmButtonText: "خٌب",
                                    confirmButtonClass: "btn btn-outline-default",
                                    buttonsStyling: false
                                });
                            }
                            if (response.error.text) {
                                Swal.fire({
                                    title: '',
                                    text: response.error.text,
                                    type: "error",
                                    confirmButtonText: "خٌب",
                                    confirmButtonClass: "btn btn-outline-default",
                                    buttonsStyling: false
                                });
                            }
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

    </script>
@endsection
