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
                        <a href="{{ url('http://localhost/Laravelpro/ismart/lien-he') }}">
                            Liên hệ
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div id="wrapper" class="container clearfix">
        {!! Form::open([
            'name' => 'form-checkout',
            'url' => 'http://localhost/Laravelpro/ismart/thong-bao-lien-he',
            'method' => 'POST',
        ]) !!}
        <div class="section" id="contact-info-wp">
            <div class="section-head">
                <h1 class="section-title">Liên hệ trực tuyến</h1>
            </div>
            <div class="section-detail">
                <div class="form-group">
                    {!! Form::label('fullname', 'Họ tên') !!}
                    {!! Form::text('fullname', '', [
                        'class' => 'form-control',
                        'id' => 'fullname',
                    ]) !!}
                    @error('fullname')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', '', [
                        'class' => 'form-control',
                        'id' => 'email',
                    ]) !!}
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('phone', 'Số điện thoại') !!}
                    {!! Form::tel('phone', '', [
                        'class' => 'form-control',
                        'id' => 'phone',
                    ]) !!}
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('notes', 'Ghi chú') !!}
                    {!! Form::textarea('notes', '', [
                        'class' => 'form-control',
                    ]) !!}
                    @error('notes')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::submit('Gửi tin', [
                        'name' => 'send-now',
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'value' => 'Gửi tin',
                    ]) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="section" id="map-wp">
            <div class="section-head">
                <h1 class="section-title">{{ $page->title }}</h1>
            </div>
            <div class="section-detail">
                <p>{!! $page->content !!}</p>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d501725.3382147796!2d106.41502403989591!3d10.755341096674579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e8d3dd1%3A0xf15f5aad773c112b!2zSOG7kyBDaMOtIE1pbmgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1672058949888!5m2!1svi!2s"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection
