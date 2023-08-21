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
                    <div class="card-header font-weight-bold">
                        Thêm hình ảnh cho sản phẩm
                    </div>
                    <div class="card-body">
                        <h4 class="text-info">{{ $products->product_name }}</h4>
                        {!! Form::open([
                            'url' => route('admin.product.update_img', ['id' => $products->id]),
                            'method' => 'POST',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        @csrf
                        <div class="form-group">
                            {!! Form::label('file-product', 'Thêm ảnh phụ') !!}
                            <div style="width: 300px;">
                                {!! Form::file('file-product', [
                                    'id' => 'file-product',
                                    'class' => 'form-control-file',
                                ]) !!}
                            </div>
                            @error('file-product')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {!! Form::submit('Thêm mới', ['class' => 'btn btn-primary', 'name' => 'add_product']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách hình ảnh phụ sản phẩm
                    </div>
                    <div class="card-body" style="min-height: 500px">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Hình ảnh phụ</th>
                                    <th scope="col" class="text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($product_images as $product_image)
                                @if ($product_image->product_id === $products->id)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td scope="row">{{ $t }}</td>
                                        <td><img style="max-width: 100px;" src="{{ asset($product_image->image_url) }}"
                                                alt="" class="img-fluid"></td>
                                        <td class="text-center">
                                            <a href="{{ route('delete_img', $product_image->id) }}" onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
