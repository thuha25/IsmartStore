@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-4">
        <div class="row dashboard-cards-wp">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$successfulOrdersCount}}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;height:92%">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$processingOrdersCount}}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info mb-3" style="max-width: 18rem;height:92%">
                    <div class="card-header">Đang vận chuyển</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$moveOrdersCount}}</h5>
                        <p class="card-text">Đơn hàng đang vận chuyển</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem; height:92%">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem; height:92%">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$cancelOrdersCount}}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col" class="text-center">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col" class="text-center">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->total() > 0)
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($orders as $order)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>{{ $t }}</td>
                                    <td>
                                        <a
                                            href="{{ route('admin.order.detail', ['id' => $order->orderdetail->first()->idDH]) }}">ISM_{{ $order->idDH }}</a>
                                    </td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ number_format($order->orderdetail->first()->total_sum, 0, ',', '.') }}đ</td>
                                    <td class="text-center">
                                        @if ($order->state === 'Đang xử lý')
                                            <span class="badge badge-warning">{{ $order->state }}</span>
                                        @elseif ($order->state === 'Đang vận chuyển')
                                            <span class="badge badge-info">{{ $order->state }}</span>
                                        @elseif ($order->state === 'Hoàn thành')
                                            <span class="badge badge-success">{{ $order->state }}</span>
                                        @elseif ($order->state === 'Hủy đơn')
                                            <span class="badge badge-danger">{{ $order->state }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $order->state }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.order.detail', ['id' => $order->orderdetail->first()->idDH]) }}"
                                            class="text-primary border rounded-circle px-1"><i class="fa fa-ellipsis-h"
                                                aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="bg-white">Không tìm thấy đơn hàng nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    @endsection
