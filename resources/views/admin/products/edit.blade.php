@extends('admin.layouts.admin3')
@section('title')
    ویرایش مقاله
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('assets3/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets3/vendor/summernote/summernote.css')}}">
@endsection

@section('content')
    <div class="header">
        <h6 class="h2 mb-0 mt-3">ویرایش مقاله</h6>
        <div class="header-body">
            <div class="col-12 py-4">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/blogs')}}">لیست مقالات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ویرایش مقاله</li>
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
                        <div class="img_upload">
                            <img src="" alt="">
                            <button class="btn" type="button">انتخاب عکس</button>
                            <input type="file" class="file_upload" name="blog_img">
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">عنوان <i class="fas fa-star-of-life text-red"
                                                                   style="font-size:8px;"></i></label>
                        <input type="text" class="form-control form-control-alternative" name="title" placeholder=""
                               value="{{$article->title}}">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">خلاصه توضیحات <i class="fas fa-star-of-life text-red"
                                                                           style="font-size:8px;"></i></label>
                        <textarea class="form-control form-control-alternative" name="description"
                                  placeholder="">{{$article->description}}</textarea>
                    </div>
                </div>
                <div class="form-row mb-3" style="height:450px;">
                    <div class="col-12">
                        <label class="form-control-label">متن <i class="fas fa-star-of-life text-red"
                                                                 style="font-size:8px;"></i></label>
                        <textarea id="summernote" name="text"></textarea>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">دسته بندی ها <i class="fas fa-star-of-life text-red"
                                                                          style="font-size:8px;"></i></label>
                        <div class="postCategories custom-control custom-checkbox mb-3">
                            <ul class="custom-control custom-checkbox mb-3">
                                @foreach($allCategories as $category)
                                    <li>
                                        <input type="checkbox" name="categories" value="{{ $category->id }}"
                                                {{ in_array($category->id,$categories) ? 'checked' : '' }}
                                        >
                                        {{ $category->title }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">کلمات کلیدی </label>
                        <input type="text" class="form-control" data-toggle="tags" name="tags" value="{{$tags}}"/></div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">وضعیت انتشار
                            <i class="fas fa-star-of-life text-red" style="font-size:8px;"></i></label>
                        <select name="articleStatus" id="articleStatus" class="form-control">
                            @foreach($articleStatus as $key=>$value)
                                <option value="{{$key}}" {{$key==$article->status ? 'checked':''}}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="my-1 w-75 border-light">
                <hr class="my-1 w-75 border-light">
                <h3>اطلاعات سئو</h3>
                <div class="col-12">
                    <div class="img_upload">
                        <img src="" alt="">
                        <button class="btn" type="button">انتخاب عکس</button>
                        <input type="file" class="file_upload" name="meta_data_image">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">عنوان <i class="fas fa-star-of-life text-red"
                                                                   style="font-size:8px;"></i></label>
                        <input type="text" class="form-control form-control-alternative" name="meta_data_title"
                               placeholder="" value="{{$article->meta_tag->title}}">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">توضیحات <i class="fas fa-star-of-life text-red"
                                                                     style="font-size:8px;"></i></label>
                        <input type="text" class="form-control form-control-alternative" name="meta_data_description"
                               placeholder="" value="{{$article->meta_tag->description}}">
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">کلمات کلیدی </label>
                        <input type="text" class="form-control" data-toggle="tags" name="meta_data_keyword"
                               value="{{$article->meta_tag->keyword}}"/></div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12">
                        <label class="form-control-label">نویسنده</label>
                        <input type="text" class="form-control form-control-alternative" name="meta_data_author"
                               placeholder="" value="{{$article->meta_tag->author}}">
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
        $('input[name="meta_data_keyword"]').tagsinput({tagClass: 'label bg-primary font-15'});
        $('input[name="tags"]').tagsinput({tagClass: 'label bg-primary font-15'});

        var editor = $('#summernote').summernote({
            height: '350px', rtl: true
        });
        $('.note-editor button').removeClass('btn-default');

        $(document).ready(function () {
            var image = "<?=url('storage/' . $article->image)?>";
            var imageSeo = "<?=url('storage/' . $article->meta_tag->image)?>";

            $('input[name="blog_img"]').closest('.img_upload').children('img').attr('src', image);
            $('input[name="meta_data_image"]').closest('.img_upload').children('img').attr('src', imageSeo);

            $('#summernote').summernote('code', '<?=$article->text?>');
        });

        var form_data = new FormData();
        $('.img_upload .file_upload').change(function (event) {
            form_data.append($(this).attr('name'), event.target.files[0]);
        });
        $('.img_upload button').click(function (e) {
            e.preventDefault();
            $(this).parent().children('input[type="file"]').click();
        });

        $('.btn_edit_confirm').click(function () {
            var title = $('.card-body input[name="title"]').val();
            var description = $('.card-body textarea[name="description"]').val();
            var text = $('#summernote').summernote('code');
            var tags = $('.card-body input[name="tags"]').val();
            var CheckCategories = [];
            var categories = $('.card-body input[name="categories"]:checked').each(function () {
                CheckCategories.push($(this).val());
            });
            var articleStatus = $('.card-body select[name="articleStatus"]').val();
            var meta_data_title = $('.card-body input[name="meta_data_title"]').val();
            var meta_data_description = $('.card-body input[name="meta_data_description"]').val();
            var meta_data_keyword = $('.card-body input[name="meta_data_keyword"]').val();
            var meta_data_author = $('.card-body input[name="meta_data_author"]').val();

            // if (title != "" && description != "" && text != "") {
            if (1) {
                form_data.append('_method', 'PUT');
                form_data.append('_token', $('meta[name=csrf-token]').attr('content'));
                form_data.append('title', title);
                form_data.append('description', description);
                form_data.append('text', text);
                form_data.append('tags', tags);
                form_data.append('categories', CheckCategories);
                form_data.append('articleStatus', articleStatus);
                form_data.append('meta_data_title', meta_data_title);
                form_data.append('meta_data_description', meta_data_description);
                form_data.append('meta_data_keyword', meta_data_keyword);
                form_data.append('meta_data_author', meta_data_author);
                load_screen(true);
                $.ajax({
                    url: "{{url('admin/articles/'.$article->id)}}",
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
