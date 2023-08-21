@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Cập nhật vai trò</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' => route('admin.role.update',$role->id),
                    'method' => 'POST',
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Tên vai trò') !!}
                    {!! Form::text('name', $role->name, ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off']) !!}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Mô tả') !!}
                    {!! Form::text('description',$role->description, [
                        'class' => 'form-control',
                        'id' => 'description',
                        'rows' => 3,
                    ]) !!}
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <strong>Vai trò này có quyền gì?</strong>
                <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                    quyền.</small>
                @foreach ($permissions as $moduleName => $modulePermissions)
                    <div class="card my-4 border">
                        <div class="card-header">
                            {!! Form::checkbox(null,null,null,['class'=>'check-all','id'=> $moduleName ]) !!}
                            {!! html_entity_decode(Form::label( $moduleName ,'<strong>Module '. ucfirst($moduleName) .'</strong>'))!!}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($modulePermissions as $permission)
                                    <div class="col-md-3">
                                        {!! Form::checkbox('permission_id[]',$permission->id,in_array($permission->id, $role->permissions->pluck('id')->toArray()),['class'=>'permission','id'=> $permission->slug ]) !!}
                                        {!! Form::label($permission->slug, $permission->name ) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <input type="submit" name="btn-add" class="btn btn-primary" value="Cập nhật">
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.check-all').click(function() {
            $(this).closest('.card').find('.permission').prop('checked', this.checked)
        })
    </script>
@endsection
