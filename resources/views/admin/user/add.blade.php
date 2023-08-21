@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => route('admin.user.store'),
                    'method' => 'POST',
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Họ và tên') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off']) !!}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off']) !!}
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'Mật khẩu') }}
                    {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {{ Form::label('password-confirm', 'Xác nhận mật khẩu') }}
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm']) }}
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('roles', 'Nhóm quyền') !!}
                    {!! Form::select('roles[]',  $roles->pluck('name', 'id'), null, [
                        'id' => 'roles',
                        'class' => 'form-control',
                        'multiple'=>true
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::button('Thêm mới', [
                        'name' => 'btn-add',
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'value' => 'Thêm mới',
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>
@endsection
