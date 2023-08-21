@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thêm thương hiệu cho sản phẩm
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'url' => 'http://localhost/Laravelpro/ismart/admin/product/product-brand/store',
                            'method' => 'POST',
                            'files' => true,
                        ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Tên thương hiệu') !!}
                            {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'slug', 'onkeyup' => 'ChangeToSlug()']) !!}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug đường dẫn') !!}
                            {!! Form::text('slug', '', ['class' => 'form-control', 'id' => 'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('file-brand', 'Ảnh thương hiệu') !!}
                            {!! Form::file('file-brand', [
                                'id' => 'file-brand',
                                'class' => 'form-control-file',
                            ]) !!}
                            @error('file-brand')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::button('Thêm mới', [
                                'name' => 'btn-add',
                                'class' => 'btn btn-primary',
                                'type' => 'submit',
                                'value' => 'addBrand',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách thương hiệu
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên thương hiệu</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($brands as $brand)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $t }}</th>
                                        <td>{{ $brand->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.product.editBrand', $brand->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.product.deleteBrand', $brand->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white"
                                                type="button"data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="return confirm('Bạn có muốn xoá?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
