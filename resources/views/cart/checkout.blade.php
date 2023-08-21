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
                            Thanh toán
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="pay__content">
        <div class="container">
            {!! Form::open([
                'url' => 'http://localhost/Laravelpro/ismart/order/add',
                'method' => 'POST',
            ]) !!}
            <div class="row">
                <div class="col-6">
                    <div class="customer__container">
                        <div class="pay__header">
                            <h3>Thông tin khách hàng</h3>
                        </div>
                        <div class="customer__form">
                            <div class="form-group">
                                {!! Form::label('customer_name', 'Họ tên (*)') !!}
                                {!! Form::text('customer_name', '', ['class' => 'form-control', 'id' => 'customer_name', 'autocomplete'=>"off"]) !!}
                                @error('customer_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                {!! Form::label('customer_phone', 'Số điện thoại (*)') !!}
                                {!! Form::text('customer_phone', '', ['class' => 'form-control', 'id' => 'customer_phone','autocomplete'=>"off"]) !!}
                                @error('customer_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                {!! Form::label('customer_email', 'Địa chỉ Email (*)') !!}
                                {!! Form::text('customer_email', '', ['class' => 'form-control', 'id' => 'customer_email','autocomplete'=>"off"]) !!}
                                @error('customer_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-address">
                                {!! Form::label('customer_address', 'Địa chỉ (*)') !!}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            {!! Form::select('province_id', [],  old('province_id'), [
                                                'id' => 'city',
                                                'class' => 'form-control',
                                                'placeholder' => 'Chọn Tỉnh/ Thành phố',
                                               
                                            ]) !!}
                                            @error('province_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {!! Form::select('ward_id', [], old('ward_id'), [
                                                'id' => 'ward',
                                                'class' => 'form-control',
                                                'placeholder' => 'Chọn Phường/ Xã',
                                            ]) !!}
                                            @error('ward_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            {!! Form::select('district_id', [], old('district_id'), [
                                                'id' => 'district',
                                                'class' => 'form-control',
                                                'placeholder' => 'Chọn Quận/ Huyện',

                                            ]) !!}
                                            @error('district_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {!! Form::input('text', 'num_house',  old('num_house'), ['class' => 'form-control', 'placeholder' => 'Số nhà, tên đường','autocomplete'=>"off"]) !!}
                                            @error('num_house')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('customer_note', 'Ghi chú') !!}
                                {!! Form::textarea('customer_note', '', [
                                    'class' => 'form-control',
                                    'id' => 'customer_note',
                                    'cols' => 30,
                                    'rows' => 5,
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="cart__container">
                        <div class="pay__header">
                            <h3>Thông tin đơn hàng</h3>
                        </div>
                        <div class="cart__info">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td>Tổng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cat as $row)
                                        <tr>
                                            <td>{{ $row->name }}<strong> - Màu: {{ $row->options->color}} X {{ $row->qty }}</strong></td>
                                            <td>{{ number_format($row->total, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Tổng đơn hàng:</td>
                                        <td>{{ Cart::total() }}đ</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <ul id="payment_methods">
                                <li>
                                    {!! Form::radio('status', 'online-payment', false, ['id' => 'direct-payment']) !!}
                                    {!! Form::label('direct-payment', 'Thanh toán online') !!}
                                </li>
                                <li>
                                    {!! Form::radio('status', 'payment-home', true, ['id' => 'payment-home']) !!}
                                    {!! Form::label('payment-home', 'Thanh toán tại nhà') !!}
                                </li>
                            </ul>

                            <div class="place__order">
                                {!! Form::button('Đặt hàng', [
                                    'class' => 'btn__order',
                                    'type' => 'submit',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
