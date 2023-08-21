@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thông tin sản phẩm
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => route('admin.product.update', $products->id),
                    'method' => 'POST',
                    'files' => true,
                ]) !!}
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('product_name', 'Tên sản phẩm') !!}
                            {!! Form::text('product_name', $products->product_name, [
                                'class' => 'form-control',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                                'autocomplete' => 'off',
                            ]) !!}
                            @error('product_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug link rút gọn') !!}
                            {!! Form::text('slug', '', ['class' => 'form-control','id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('product_price', 'Giá') !!}
                            {!! Form::text('product_price', $products->product_price, [
                                'class' => 'form-control',
                                'id' => 'product_price',
                                'autocomplete' => 'off',
                            ]) !!}
                            @error('product_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('color_product', 'Chọn màu sản phẩm') !!}
                            <div class="selected-color">
                                <ul class="d-flex flex-wrap">
                                   
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <ul class="product_color_list d-flex flex-wrap">
                            @foreach ($colors as $color)
                                <li>
                                    <div class="product_color">
                                        <span>{{ $color->color_name }}
                                            <input type="checkbox" name="color_selector[]" id=""
                                                value="{{ $color->id }}" hidden>
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="form-group">
                            {!! Form::label('color_product', 'Màu đã chọn') !!}
                            <div class="select-color ">
                                <ul class="d-flex flex-wrap">
                                    @foreach ($colorsSelected as $colorSelected)
                                        <li>
                                            <div class="product-color-active p-1" style="pointer-events: none;">
                                                <span class="enable">{{ $colorSelected->color_name }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @error('color_selector')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('category', 'Danh mục') !!}
                    {!! Form::select(
                        'category',
                        ['' => 'Chọn danh mục'] + ($categories ? $categories->pluck('name', 'id')->toArray() : []),
                        $products->category_id,
                        [
                            'class' => 'form-control',
                        ],
                    ) !!}
                    @error('category')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('brand', 'Thương hiệu') !!}
                    {!! Form::select(
                        'brand',
                        ['' => 'Chọn thương hiệu'] + ($brands ? $brands->pluck('name', 'id')->toArray() : []),
                        $products->brand_id,
                        ['class' => 'form-control'],
                    ) !!}
                    @error('brand')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::file('images_product', [
                        'id' => 'images-product',
                        'accept' => 'image/png, image/jpg, image/jpeg',
                        'style' => 'display: none;',
                    ]) !!}
                    {!! Form::label('images-product', 'Ảnh bìa sản phẩm', ['class' => 'image-label']) !!}
                    <div class="preview">
                        <div class="images-product-container">
                            <div class="black-bg">
                                <div class="change-img-btn">
                                    <span>
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </div>
                            </div>
                            <img src="{{ asset($products->thumbnail_path) }}" alt="">
                        </div>
                    </div>
                    @error('images_product')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('describe', 'Mô tả sản phẩm') !!}
                    {!! Form::textarea('describe', $products->describe, [
                        'class' => 'form-control',
                        'id' => 'describe',
                        'cols' => '30',
                        'rows' => '5',
                    ]) !!}
                    @error('describe')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('product_content', 'Chi tiết sản phẩm') !!}
                    {!! Form::textarea('product_content', $products->product_content, [
                        'class' => 'form-control',
                        'id' => 'product_content',
                    ]) !!}
                    @error('product_content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('status', 'Trạng thái') !!}
                    <div class="form-check">
                        {!! Form::radio('status', 'Còn hàng', true, ['class' => 'form-check-input', 'id' => 'availability']) !!}
                        {!! Form::label('availability', 'Còn hàng', ['class' => 'form-check-label']) !!}
                    </div>
                    <div class="form-check">
                        {!! Form::radio('status', 'Hết hàng', false, ['class' => 'form-check-input', 'id' => 'outofstock']) !!}
                        {!! Form::label('outofstock', 'Hết hàng', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::button('Cập nhật', [
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'id' => 'submitButton',
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
