@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header font-weight-bold">
                Thông tin bài viết
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => route('admin.post.updatePost', $posts->id),
                    'method' => 'POST',
                    'files' => true,
                ]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Tiêu đề bài viết') !!}
                    {!! Form::text('title', $posts->title, [
                        'class' => 'form-control',
                        'id' => 'slug',
                        'onkeyup' => 'ChangeToSlug()',
                    ]) !!}
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('slug', 'Slug link rút gọn') !!}
                    {!! Form::text('slug', $posts->slug, ['class' => 'form-control', 'id' => 'convert_slug']) !!}
                </div>
                <div class="form-group">
                    {!! Form::file('post_thumb', [
                        'id' => 'post-thumb',
                        'accept' => 'image/png, image/jpg, image/jpeg',
                        'style' => 'display: none;',
                    ]) !!}
                    {!! Form::label('post-thumb', 'Ảnh bìa bài viết', ['class' => 'image-label']) !!}
                    <div class="preview">
                        <div class="post-thumb-container">
                            <div class="black-bg">
                                <div class="change-img-btn">
                                    <span>
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </div>
                            </div>
                            <img src="{{ asset($posts->thumbnail_path) }}" alt="">
                        </div>
                    </div>
                    @error('post_thumb')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Danh mục đã được chọn</label>
                    <div class="selected-categories">
                        <ul class="d-flex flex-wrap">
                            @foreach ($categories as $category)
                                <li>
                                    <div class="post-category @if ($categories->contains('id', $category->id)) post-category-active @endif" data-id="{{ $category->id }}">
                                        <span><i class="fas fa-times"></i>{{ $category->name }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr>
                    <ul class="post-categories-list d-flex flex-wrap">
                        @foreach ($cat_posts as $cat_post)
                            <li>
                                <div class="post-category  @if ($categories->contains('id', $cat_post->id)) post-category-active @endif">
                                    <span>{{ $cat_post->name }}
                                    <input @if ($categories->contains('id', $cat_post->id)) checked @endif type="checkbox" name="categories_selector[]" id=""
                                        value="{{ $cat_post->id }}" hidden>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @error('categories_selector')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('content', 'Nội dung bài viết') !!}
                    {!! Form::textarea('content', $posts->content, ['class' => 'form-control']) !!}
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('state', 'Trạng thái') !!}
                    <div class="form-check">
                        {!! Form::radio('state', 'Chờ duyệt',$posts->state === 'Chờ duyệt', ['class' => 'form-check-input', 'id' => 'pending']) !!}
                        {!! Form::label('pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                    </div>
                    <div class="form-check">
                        {!! Form::radio('state', 'Công khai',$posts->state === 'Công khai', ['class' => 'form-check-input', 'id' => 'publish']) !!}
                        {!! Form::label('publish', 'Công khai', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::button('Cập nhật', [
                        'name' => 'btn-update',
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'value' => 'addPost',
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function ChangeToSlug() {
            var slug;
            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
@endsection
