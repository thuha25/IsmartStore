@extends('layouts.home')

@section('content')
    <div id="main-content-wp" class="clearfix">
        <div class="container">
            <div class="breadcrumb__container">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('http://localhost/Laravelpro/ismart/') }}">
                                <i class="bi bi-house-door-fill"></i>
                                Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ url('http://localhost/Laravelpro/ismart/tin-tuc') }}">
                                Tin tức
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="main-content fl-right pl-5">
                <div class="container">
                    @foreach ($products as $product)
                        @if ($product->slug === request()->segment(2))
                            <div class="product-content">
                                <h1 class="mt-3">{{ $product->title }}</h1>
                                <div class="text-muted mb-2 mt-2">
                                    <span class="mr-3"><i class="fa fa-user" aria-hidden="true"></i> Thu hà</span>
                                    <span class=""><i class="fa fa-clock-o" aria-hidden="true"></i>{{ $product->created_at->format('Y-m-d') }}</span>
                                </div>
                                <p>{!! $product->content !!}</p>
                                
                            </div>
                        @endif
                    @endforeach
                    
                    @foreach ($promotions as $promotion)
                    @if ($promotion->slug === request()->segment(2))
                        <div class="product-content">
                            <h1 class="mt-3">{{ $promotion->title }}</h1>
                            <div class="text-muted mb-2 mt-2">
                                <span class="mr-3"><i class="fa fa-user" aria-hidden="true"></i> Thu hà</span>
                                <span class=""><i class="fa fa-clock-o" aria-hidden="true"></i>{{ $promotion->created_at->format('Y-m-d') }}</span>
                            </div>
                            <p>{!! $promotion->content !!}</p>
                            
                        </div>
                    @endif
                @endforeach


                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section mt-0" id="banner-wp" style="border:none">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img src="{{ asset('/images/banner-1.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
