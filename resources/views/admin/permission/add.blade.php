@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm quyền
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'url' => route('admin.permission.store'),
                            'method' => 'POST',
                        ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Tên quyền') !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off']) !!}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug') !!}
                            <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                            {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'id' => 'slug', 'autocomplete' => 'off']) !!}
                            @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả') !!}
                            {!! Form::textarea('description', old('description'), [
                                'class' => 'form-control',
                                'id' => 'description',
                                'rows' => 3,
                            ]) !!}
                        </div>
                        {!! Form::button('Thêm mới', [
                            'name' => 'btn-add',
                            'class' => 'btn btn-primary',
                            'type' => 'submit',
                        ]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($permissions as $moduleName => $modulePermissions)
                                    <tr>
                                        <td></td>
                                        <td><strong>Module {{ ucfirst($moduleName) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($modulePermissions as $permission)
                                        <tr>
                                            <td>{{ $t++ }}</td>
                                            <td>|---{{ $permission->name }}</td>
                                            <td>{{ $permission->slug }}</td>
                                            <td>
                                                <a href="{{ route('admin.permission.edit', $permission->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.permission.delete', $permission->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
