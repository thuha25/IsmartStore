@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm Trang
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => 'http://localhost/Laravelpro/ismart/admin/page/store',
                    'method' => 'POST',
                    'files' => true,
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name_page', 'Tên trang') !!}
                    {!! Form::text('name_page', '', ['class' => 'form-control', 'id' => 'slug', 'onkeyup' => 'ChangeToSlug()']) !!}
                    @error('name_page')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('slug', 'Slug link rút gọn') !!}
                    {!! Form::text('slug', '', ['class' => 'form-control','id'=>'convert_slug']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Tiêu đề trang') !!}
                    {!! Form::text('title', '', ['class' => 'form-control']) !!}
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('content', 'Nội dung chi tiết') !!}
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
