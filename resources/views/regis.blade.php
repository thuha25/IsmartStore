@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="order-success-page">
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="notification-wp">
            <div class="section-head">
                <h3 class="section-title">Hệ thống đã tiếp nhận thông tin đăng ký của quý khách</h3>
            </div>
        </div>
        <div class="cart-empty">
            <a href="{{ url('http://localhost/Laravelpro/ismart/') }}">Quay trở lại trang chủ</a>
        </div>
    </div>
</div>
@endsection
