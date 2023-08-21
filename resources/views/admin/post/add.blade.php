@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm Bài viết
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => 'http://localhost/Laravelpro/ismart/admin/post/store',
                    'method' => 'POST',
                    'files' => true,
                ]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Tiêu đề bài viết') !!}
                    {!! Form::text('title', '', ['class' => 'form-control', 'id' => 'slug', 'onkeyup' => 'ChangeToSlug()']) !!}
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('slug', 'Slug link rút gọn') !!}
                    {!! Form::text('slug', '', ['class' => 'form-control', 'id' => 'convert_slug']) !!}
                </div>
                <div class="form-group">
                    {!! Form::file('post_thumb', [
                        'id' => 'post-thumb',
                        'accept' => 'image/png, image/jpg, image/jpeg',
                        'style' => 'display: none;',
                    ]) !!}
                    {!! Form::label('post-thumb', 'Ảnh bìa bài viết', ['class' => 'image-label']) !!}
                    <div class="preview">
                        <div class="add-file-btn">
                            <i class="fa fa-plus d-block"></i>
                        </div>
                    </div>
                    @error('post_thumb')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Chọn danh mục</label>
                    <div class="selected-categories">
                        <ul class="d-flex flex-wrap">
                        </ul>
                    </div>
                    <hr>
                    <ul class="post-categories-list d-flex flex-wrap">
                        @foreach ($cat_posts as $cat_post)
                            <li>
                                <div class="post-category">
                                    <span>{{ $cat_post->name }}
                                    <input type="checkbox" name="categories_selector[]"
                                            id="" value="{{ $cat_post->id }}" hidden></span>
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
                    {!! Form::textarea('content', '', ['class' => 'form-control']) !!}
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('state', 'Trạng thái') !!}
                    <div class="form-check">
                        {!! Form::radio('state', 'Chờ duyệt', 'checked', ['class' => 'form-check-input', 'id' => 'pending']) !!}
                        {!! Form::label('pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                    </div>
                    <div class="form-check">
                        {!! Form::radio('state', 'Công khai', '', ['class' => 'form-check-input', 'id' => 'publish']) !!}
                        {!! Form::label('publish', 'Công khai', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::button('Thêm mới', [
                        'name' => 'btn-add',
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'value' => 'addPage',
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
