@extends('layouts.home')

@section('content')
<div id="main-content-wp" class="order-success-page">
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="notification-wp">
            <div class="section-head">
                <h3 class="section-title">Hệ thống đã tiếp nhận thông tin liên hệ của quý khách</h3>
            </div>
            <div class="section-detail">
                <P style="text-align:center">Bộ phận nhân viên chăm sóc khách hàng <span style="font-weight:bold">ISMART</span> sẽ liên hệ với quý khách sớm nhất, quý khách vui lòng chờ đợi sự phản hồi bên nhân viên chúng tôi</P>
            </div>
        </div>
        <div class="cart-empty">
            <a href="{{ url('http://localhost/Laravelpro/ismart/') }}">Quay trở lại trang chủ</a>
        </div>
    </div>
</div>
@endsection
