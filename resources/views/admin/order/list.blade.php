@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 "><a href="{{ route('admin.order.list') }}">Danh sách đơn hàng</a></h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="text" name="keyword" value="{{ request()->input('keyword') }}"
                            class="form-control form-search" placeholder="Tìm kiếm theo tên" autocomplete="off">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['state' => 'all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['state' => 'complete']) }}" class="text-primary">Hoàn
                        thành<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['state' => 'move']) }}" class="text-primary">Đang vận
                        chuyển<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['state' => 'processing']) }}" class="text-primary">Đang xử
                        lý<span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['state' => 'cancel']) }}" class="text-primary">Đơn hàng
                        huỷ<span class="text-muted">({{ $count[4] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['state' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[5] }})</span></a>
                </div>
                <form action="{{ url('admin/order/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select name="act" class="form-control mr-1" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        @can('order.edit')
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        @else
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary" disabled>
                        @endcan
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col" class="text-center">Chi tiết</th>
                                <th scope="col" class="text-center">Tác vụ</th>
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
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $order->idDH }}">
                                        </td>
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
                                        <td>
                                            <div class="text-center"><a
                                                    href="{{ route('admin.order.delete_order', $order->orderdetail->first()->idDH) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white " type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không?')"><i
                                                        class="fa fa-trash"></i></a></div>
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
                </form>
            </div>
        </div>
    </div>
@endsection
