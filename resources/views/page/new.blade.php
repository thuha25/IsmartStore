@extends('layouts.home')

@section('content')
    <main class="py-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
                </div>
                <div class="col-md-8">
                    <h4 style="text-transform: uppercase; font-size:20px">{{$productNew}}</h4>
                    <span class=" border border-2 border-muted" style="display: block"></span>
                    <div>
                        <ul class="list-post-new">
                            @foreach ($products as $product)
                                <li class="pt-3 pb-3">
                                    <div class="clearfix">
                                        <div class="float-left" style="max-width: 28%;">
                                            <a href="{{ asset('http://localhost/Laravelpro/ismart/tin-tuc/' . $product->slug) }}" class="p-r-4">
                                                <img src="{{ asset($product->thumbnail_path) }}" alt="">
                                            </a>
                                        </div>
                                        <h1 class="float-left title-post pl-5" style="max-width: 70%;">
                                            <a href="{{ asset('http://localhost/Laravelpro/ismart/tin-tuc/' . $product->slug) }}">{{ $product->title }}</a>

                                        </h1>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 style="text-transform: uppercase; font-size:20px">{{$promotion}}</h4>
                    <span class=" border border-2 border-muted" style="display: block"></span>
                    <div>
                        <ul class="list-post-new">
                            @foreach ($promotions as $promotion)
                            <li class="pt-3 pb-3">
                                <div>
                                    <div class="" style=""><a
                                            href="{{ asset('http://localhost/Laravelpro/ismart/tin-tuc/' . $promotion->slug) }}"
                                            class="p-r-4"><img
                                                src="{{ asset($promotion->thumbnail_path) }}"
                                                alt=""></a></div>
                                    <h5 class="title-post mt-3"><a
                                            href="{{ asset('http://localhost/Laravelpro/ismart/tin-tuc/' . $promotion->slug) }}">{{ $promotion->title }}</a></h5>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
