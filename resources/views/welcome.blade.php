@extends('layouts.home')
@section('content')
    <div class="slider">
        <div class="container">
            <div class="slider__content">
                @foreach($sliders as $slider)
                <div>
                    <a>
                        <img src="{{ asset($slider->image_url) }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="support">
        <div class="container">
            <div class="support__list">
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-1.png') }}" alt="">
                    </div>
                    <h3>Miễn phí vận chuyển</h3>
                    <p>Tới tận tay khách hàng</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-2.png') }}" alt="">
                    </div>
                    <h3>Tư vấn 24/7</h3>
                    <p>1900.9999</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-3.png') }}" alt="">
                    </div>
                    <h3>Tiết kiệm hơn</h3>
                    <p>Với nhiều ưu đãi cực lớn</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-4.png') }}" alt="">
                    </div>
                    <h3>Thanh toán nhanh</h3>
                    <p>Hỗ trợ nhiều hình thức</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-5.png') }}" alt="">
                    </div>
                    <h3>Đặt hàng online</h3>
                    <p>Thao tác đơn giản</p>
                </div>
            </div>
        </div>
    </div>
    <div class="banner">
        <div class="container">
            <a>
                <img style="width: 100%; object-fit: cover;" src="{{ asset('images/banner-4.png') }}">
            </a>
        </div>
    </div>
    <div class="product__like">
        <div class="container">
            <div id="title">
                <p>Có thể bạn sẽ thích</p>
            </div>
            <div class="product__carousel">
                @foreach ($products as $product)
                    <div class="product__card">
                        <div class="card__img">
                            <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}">
                                <img src="{{ asset($product->thumbnail_path) }}">
                            </a>
                        </div>
                        <div class="card__info">
                            <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}"
                                class="product__title">{{ $product->product_name }}</a>
                            <p class="product__price new">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                            @if (isset($product->price_old))
                                <p class="product__price old">{{ number_format($product->price_old, 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @foreach (['Laptop', 'Điện thoại'] as $categoryName)
        <div class="product__container">
            <div class="container">
                <div id="title">
                    <p>
                        @if ($categoryName === 'Laptop')
                            Laptop nổi bật
                        @elseif ($categoryName === 'Điện thoại')
                            Điện thoại nổi bật
                        @endif
                    </p>
                </div>
                <div class="product__list">
                    @foreach ($products as $product)
                        @if ($product->category->name === $categoryName)
                            <div class="product__item">
                                <div class="product__card" style="height: 360px">
                                    <div class="card__img">
                                        <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}">
                                            <img src="{{ asset($product->thumbnail_path) }}">
                                        </a>
                                    </div>
                                    <div class="card__info" style="height: 100px">
                                        <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}" class="product__title"
                                            style="height: 60px">{{ $product->product_name }}</a>
                                        <p class="product__price new">
                                            {{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                        @if (isset($product->price_old))
                                            <p class="product__price old">
                                                {{ number_format($product->price_old, 0, ',', '.') }}đ</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @if ($loop->iteration === 1)
            <div class="banner">
                <div class="container">
                    <a>
                        <img style="width: 100%; object-fit: cover;" src="{{ asset('images/banner-6.png') }}">
                    </a>
                </div>
            </div>
        @elseif ($loop->iteration === 2)
            <div class="banner">
                <div class="container">
                    <a>
                        <img style="width: 100%; object-fit: cover;" src="{{ asset('images/banner-5.png') }}">
                    </a>
                </div>
            </div>
        @endif
    @endforeach

    <div class="product__like">
        <div class="container">
            <div id="title">
                <p>Đồng hồ thông minh</p>
            </div>
            <div class="product__carousel">
                @foreach ($products as $product)
                    @if ($product->category->name === 'Smartwatch')
                        <div class="product__card">
                            <div class="card__img">
                                <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}">
                                    <img src="{{ asset($product->thumbnail_path) }}">
                                </a>
                            </div>
                            <div class="card__info">
                                <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}" class="product__title">{{ $product->product_name }}</a>
                                <p class="product__price new">{{ number_format($product->product_price, 0, ',', '.') }}đ
                                </p>
                                @if (isset($product->price_old))
                                    <p class="product__price old">{{ number_format($product->price_old, 0, ',', '.') }}đ
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @foreach (['SmartTV', 'Tai nghe'] as $categoryName)
        <div class="product__like">
            <div class="container">
                <div id="title">
                    <p>{{ $categoryName }}</p>
                </div>
                <div class="product__carousel">
                    @foreach ($products as $product)
                        @if ($product->category->name === $categoryName)
                            <div class="product__card">
                                <div class="card__img">
                                    <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}">
                                        <img src="{{ asset($product->thumbnail_path) }}">
                                    </a>
                                </div>
                                <div class="card__info">
                                    <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}" class="product__title">{{ $product->product_name }}</a>
                                    <p class="product__price new">
                                        {{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                    @if (isset($product->price_old))
                                        <p class="product__price old">
                                            {{ number_format($product->price_old, 0, ',', '.') }}đ
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@endsection
