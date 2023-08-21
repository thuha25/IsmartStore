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
                        <a href="">
                            Đặt hàng thành công
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div id="wrapper" class="container clearfix">
        <div class="thanks text-center mb-4">
            <h4 class="text-success mb-2">Đặt hàng thành công!</h4>
            <p class="mb-0">Cảm ơn quý khách đã đặt hàng tại hệ thống Ismart!</p>
            <p>Nhân viên chăm sóc sẽ liên hệ tới bạn sớm nhất.</p>
        </div>
        <div class="section" id="thank-wp">
            <div class="section-head mb-1">
                <h5 class="section-title">Mã đơn hàng: ISM_{{$order->idDH}}</h5>
            </div>
            <div class="section-detail">
                <div class="section">
                    <div class="section-head mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="d-block ml-2 mb-2">Thông tin khách hàng:</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Họ Tên</th>
                                            <th scope="col">Số điện thoại</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$order->customer_name}}</td>
                                            <td>{{$order->customer_phone}}</td>
                                            <td>{{$order->customer_address}}</td>
                                            <td>{{$order->customer_email}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="d-block ml-2">Thông tin đơn hàng:</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Màu</th>
                                            <th scope="col">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderDetails as $orderDetail)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td style="max-width:80px;"><img
                                                    src="{{asset($orderDetail->image_product)}}"
                                                    alt="" class="img-fluid" style="width: 100%"></td>
                                            <td>{{ $orderDetail->product_name }}</td>
                                            <td>{{ number_format($orderDetail->product_price, 2) }} đ</td>
                                            <td>{{ $orderDetail->qty }}</td>
                                            <td> {{ $orderDetail->color}}</td>
                                            <td>{{ number_format($orderDetail->total_price, 2) }} đ</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="5">Giá trị đơn hàng</th>
                                            <td>{{ number_format($orderDetail->total_sum, 2) }} đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="back-home mt-4">
                            <a href="{{route('home')}}" title="">Quay lại trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
