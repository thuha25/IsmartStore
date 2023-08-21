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
                        <a href="{{ url('http://localhost/Laravelpro/ismart/gioi-thieu') }}">
                            Giới thiệu
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page_container pt-2">
        <div class="container">
            <h1 class="" style="font-size: 25px">{{ $page->title }}</h1>
            <div class="info-post">
                <span class="create-post pl-2">
                    <i class="fas fa-clock pt-4"></i>
                    {{ $page->created_at }}
                </span>
                <p>{!! $page->content !!}</p>
            </div>

        </div>
    </div>
@endsection
