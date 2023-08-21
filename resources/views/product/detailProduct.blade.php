@extends('layouts.home')

@section('content')
    <div class="breadcrumb__container">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('http://localhost/Laravelpro/ismart/') }}">
                            <i class="bi bi-house-door-fill"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="{{ url('danh-muc/' . $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}">
                            {{ $product->product_name }}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="product__detail">
        <div class="container">
            <div class="product__deatil__header">
                <h1> {{ $product->product_name }}</h1>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="product__img_slider">
                        @foreach ($product_images as $product_image)
                            <img style="width: 100%" src="{{ asset($product_image->image_url) }}" alt="">
                        @endforeach
                    </div>

                    <div class="product__img_slider_nav">
                        @foreach ($product_images as $product_image)
                            <div class="product__img_item">
                                <img src="{{ asset($product_image->image_url) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-4">
                    <div class="product__info">
                        <h4 class="product__price">
                            {{ number_format($product->product_price, 0, ',', '.') }} đ
                        </h4>
                        <div class="freeship">
                            <i class="bi bi-truck"></i>
                            <span>MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC</span>
                        </div>
                        <div class="product__color">
                            <p>Lựa chọn màu</p>
                            <div class="color__list">
                                @foreach ($productColors as $color)
                                    <div class="color__item" data-color="{{ $color->name }}" data-id="{{ $color->id }}">
                                        {{ $color->color_name }}
                                    </div>
                                @endforeach
                                <div class="span color__err text-form text-danger" style="display: none">
                                    Vui lòng chọn màu sắc sản phẩm
                                </div>
                            </div>
                        </div>
                        <div class="product__config">
                            {!! $product->product_content !!}
                        </div>

                        <div class="product__action">
                            <a href="{{route('checkout')}}" class="product__buy" data-id="{{ $product->id }}">
                                Mua ngay
                            </a>
                            <button class="product__add_cart" data-id="{{ $product->id }}">
                                <i class="bi bi-cart-plus-fill"></i>
                                <p>Thêm vào giỏ hàng</p>
                            </button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="product__content">
                <div class="title">Mô tả sản phẩm</div>
                <div class="product__desc">
                    {!! $product->describe !!}
                </div>
                <div class="btn__more">Xem thêm</div>
            </div>
        </div>
    </div>

    <div class="product__like">
        <div class="container">
            <div id="title">
                <p>Sản phẩm tương tự</p>
            </div>
            <div class="product__carousel">
                @foreach ($products as $similarProduct)
                    @if ($similarProduct->category_id === $category->id && $similarProduct->id !== $product->id)
                        <div class="product__card">
                            <div class="card__img">
                                <a href="{{ url('san-pham', ['slug' => Str::slug($similarProduct->product_name)]) }}">
                                    <img src="{{ asset($similarProduct->thumbnail_path) }}">
                                </a>
                            </div>
                            <div class="card__info">
                                <a href="{{ url('san-pham', ['slug' => Str::slug($similarProduct->product_name)]) }}"
                                    class="product__title">{{ $similarProduct->product_name }}</a>
                                <p class="product__price new">
                                    {{ number_format($similarProduct->product_price, 0, ',', '.') }}đ</p>
                                @if (isset($similarProduct->price_old))
                                    <p class="product__price old">
                                        {{ number_format($similarProduct->price_old, 0, ',', '.') }}đ</p>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- <div id="notification__cart">
        <div class="notification__modal">
            <div class="notification__icon">
                <i class="bi bi-check2"></i>
            </div>
            <div class="notification__title">
                <h1>Đã thêm vào giỏ hàng</h1>
            </div>
            <div class="notification__footer">
                <div class="notification__close">
                    Đóng
                </div>
                <a href="{{route('cart.add',$product->id)}}" class="notification__buy">
                    Giỏ hàng
                </a>
            </div>
        </div>
    </div> --}}
@endsection
