@extends('admin.layouts.admin3')
@section('title')
    ویرایش دسته بندی
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets3/vendor/summernote/summernote.css')}}">
@endsection

@section('content')
    <div class="header">
        <h6 class="h2 mb-0 mt-3">ویرایش دسته بندی</h6>
        <div class="header-body">
            <div class="col-12 py-4">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/categories')}}">لیست دسته بندی </a></li>
                        <li class="breadcrumb-item active" aria-current="page">ویرایش دسته بندی</li>
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
                        <input type="text" class="form-control form-control-alternative" name="title" placeholder=""
                               value="{{$category->title}}">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">والد
                            <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                        <select name="parent" id="parent" class="form-control">
                            <option value="null">بدون والد</option>
                            @foreach($categories as $key=>$value)
                                <option value="{{$key}}" {{optional($category->parent)->id == $key  ? 'selected':''
                                }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-air btn_edit_confirm font-20" type="button">افزودن <i
                            class="fas fa-plus"></i></button>
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script src="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets3/vendor/summernote/summernote.js')}}"></script>
    <script src="{{asset('assets3/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>

    <script>
        $('.navbar-search').remove();
        var form_data = new FormData();

        $('.btn_edit_confirm').click(function () {
            var title = $('.card-body input[name="title"]').val();
            var parent = $('.card-body select[name="parent"]').val();

            if (title != "") {
                form_data.append('_method', 'PUT');
                form_data.append('_token', $('meta[name=csrf-token]').attr('content'));
                form_data.append('title', title);
                form_data.append('parent', parent);
                load_screen(true);
                $.ajax({
                    url: "{{url('admin/categories/'.$category->id)}}",
                    type: "post",
                    data: form_data,
                    dataType: "text",
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                    success: function (response) {
                    },
                    error: function (response) {
                        Swal.fire({title: response.responseText, type: "error", confirmButtonText: "خٌب"});
                    }
                });
            }
        });

    </script>
@endsection
