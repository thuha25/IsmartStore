@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header font-weight-bold">
                Chỉnh sửa người dùng
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => route('user.update', $user->id),
                    'method' => 'POST',
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Họ và tên') !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off']) !!}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email',  $user->email , ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off','disabled']) !!}
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
                    {!! Form::select('roles[]', $roles->pluck('name', 'id'),  $user->roles->pluck('id')->toArray(), [
                        'id' => 'roles',
                        'class' => 'form-control',
                        'multiple'=>true
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::button('Cập nhật', [
                        'name' => 'btn-update',
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'value' => 'Cập nhật',
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
