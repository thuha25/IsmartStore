@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success text-center far fa-check-circle">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex align-items-center">
                <h5 class="m-0 mr-5"><a href="">Thông tin đơn hàng</a></h5>
            </div>
            <div class="card-body" id="detail-order">
                <h5>Thông tin khách hàng</h5>
                <table style="table-layout:auto; width:100%; font-size:14px;">
                    <thead>
                        <tr style="background-color: rgb(247, 242, 242)">
                            <th class="text-center">Mã đơn hàng</th>
                            <th class="text-center">Họ và tên</th>
                            <th class="text-center">Số điện thoại</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Địa chỉ</th>
                            <th class="text-center">Thời gian đặt hàng</th>
                            <th class="text-center">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:14%;" class="text-center">ISM_{{ $orderDetails->first()->idDH }}</td>
                            <td style="width:10%;" class="text-center">{{ $orderDetails->first()->order->customer_name }}
                            </td>
                            <td style="width:8%;" class="text-center">{{ $orderDetails->first()->order->customer_phone }}
                            </td>
                            <td style="width:15%;" class="text-center">{{ $orderDetails->first()->order->customer_email }}
                            </td>
                            <td style="width:30%;" class="text-center">{{ $orderDetails->first()->order->customer_address }}
                            </td>
                            <td style="width:12%;" class="text-center">{{ $orderDetails->first()->order->created_at }}</td>
                            <td style="width:10%;">{{ $orderDetails->first()->order->customer_note }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="  mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Trạng thái đơn hàng:
                                @if ($orderDetails->first()->order->state=== 'Đang xử lý')
                                    <span class="font-size: 8px px-1 badge badge-warning">{{ $orderDetails->first()->order->state }}</span>
                                @elseif ($orderDetails->first()->order->state=== 'Đang vận chuyển')
                                    <span class="font-size: 8px badge badge-info">{{ $orderDetails->first()->order->state }}</span>
                                @elseif ($orderDetails->first()->order->state === 'Hoàn thành')
                                    <span class="font-size: 8px badge badge-success">{{ $orderDetails->first()->order->state }}</span>
                                @elseif ($orderDetails->first()->order->state === 'Hủy đơn')
                                    <span class="font-size: 8px badge badge-danger">{{ $orderDetails->first()->order->state }}</span>
                                @endif
                            </h5>
                            <div class="form-action form-inline py-2">
                                {!! Form::open([
                                    'url' => route('admin.order.update_status', ['id' => $orderDetails->first()->idDH]),
                                    'method' => 'POST',
                                    'files' => true,
                                ]) !!}
                                {!! Form::select(
                                    'status_order',
                                    [
                                        'Đang xử lý' => 'Đang xử lý',
                                        'Đang vận chuyển' => 'Đang vận chuyển',
                                        'Hoàn thành' => 'Hoàn thành',
                                        'Hủy đơn' => 'Hủy đơn',
                                    ],
                                    null,
                                    ['class' => 'form-control mr-2'],
                                ) !!}
                                {!! Form::submit('Cập nhật', [
                                    'name' => 'btn-update',
                                    'class' => 'rounded bg-primary',
                                    'type' => 'submit',
                                    'value' => 'Cập nhật',
                                    'style' => 'padding: 5px 8px;border:1px solid rgb(163, 241, 241);color:aliceblue',
                                ]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="col-md-6" style="">
                            <table style="table-layout: fixed;width:100%;font-size:14px">
                                <thead>
                                    <tr style=" background-color: rgb(247, 242, 242)">
                                        <th class="text-center">Tổng số lượng</th>
                                        <th class="text-center">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <?php
                                            $totalQuantity = 0;
                                            foreach ($orderDetails as $detail) {
                                                $totalQuantity += $detail->qty;
                                            }
                                            echo $totalQuantity;
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($orderDetails->first()->total_sum, 0, ',', '.') }}đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 "><a href="">Chi tiết đơn hàng</a></h5>
            </div>
            <div class="card-body">
                <table style="table-layout: auto;width:100%;font-size:16px;">
                    <thead>
                        <tr style="border-bottom: 1px solid gray; background-color: rgb(247, 242, 242)">
                            <th class="text-center py-2">Ảnh sản phẩm</th>
                            <th class="text-center">Tên sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Màu</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $orderDetail)
                            <tr style="border-bottom: 1px solid rgb(241, 229, 229);">
                                <td style="width:15%;" class="text-center p-2">
                                    <img src="{{ asset($orderDetail->image_product) }}" alt="" class="img-fluid"
                                        style="max-width:110px;">
                                </td>
                                <td style="width:40%;" class="text-center">{{ $orderDetail->product_name }}</td>
                                <td style="width:15%;" class="text-center">{{ $orderDetail->qty }}</td>
                                <td style="width:15%;" class="text-center">{{ $orderDetail->color }}</td>
                                <td style="width:15%;" class="text-center">
                                    {{ number_format($orderDetail->product_price, 0, ',', '.') }}đ</td>
                                <td style="width:15%;" class="text-center">
                                    {{ number_format($orderDetail->total_price, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
