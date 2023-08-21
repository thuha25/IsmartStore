@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thêm ảnh slider
                    </div>
                    <div class="card-body">
                        <h4 class="text-info"></h4>
                        {!! Form::open([
                            'url' => route('admin.slider.add'),
                            'method' => 'POST',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">
                                {!! Form::label('file-product', 'Ảnh slider') !!}
                                <div style="width: 300px;" class="mb-2">
                                    {!! Form::file('file', [
                                        'id' => 'file-slider',
                                        'class' => 'form-control-file',
                                        'onchange' => 'show_upload_image()',
                                    ]) !!}
                                </div>
                                <div class="border" style="width: 50%;height:120px; object-fit: cover;">
                                    <img src="{{ asset('images/slider') }}" alt="" id="image-slider"
                                        class="img-fluid">
                                </div>
                                @error('file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-6" style="">
                                <div class="form-group">
                                    {!! Form::label('', 'Trạng thái') !!}
                                    <div class="form-check">
                                        {!! Form::radio('status', 'Công khai', 'checked', ['class' => 'form-check-input', 'id' => 'publish']) !!}
                                        {!! Form::label('publish', 'Công khai', ['class' => 'form-check-label']) !!}
                                    </div>
                                    <div class="form-check">
                                        {!! Form::radio('status', 'Chờ duyệt', '', ['class' => 'form-check-input', 'id' => 'pending']) !!}
                                        {!! Form::label('pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @can('slider.delete')
                            {!! Form::button('Thêm mới', [
                                'name' => 'btn-add',
                                'class' => 'btn btn-primary',
                                'type' => 'submit',
                                'value' => 'Thêm mới',
                            ]) !!}
                            @else
                            {!! Form::button('Thêm mới', [
                                'name' => 'btn-add',
                                'class' => 'btn btn-primary',
                                'type' => 'submit',
                                'value' => 'Thêm mới',
                                'disabled'=>true
                            ]) !!}
                            <small class="text-danger">Bạn không có quyền</small>
                            @endcan
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách slider
                    </div>
                    <div class="card-body" style="min-height: 500px">
                        <div class="analytic mb-2">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất
                                cả<span class="text-muted">({{ $count[0] }})</span></a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary"> Công
                                khai<span class="text-muted">({{ $count[1] }})</span></a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                                duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Thứ tự</th>
                                    <th scope="col">Hình ảnh slider</th>
                                    <th scope="col" class="text-center">Trạng thái</th>
                                    <th scope="col" class="text-center">Người tạo</th>
                                    <th scope="col" class="text-center">Ngày tạo</th>
                                    <th scope="col" class="text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($sliders as $slider)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td scope="row" class="text-center">{{ $t }}</td>
                                        <td><img class="img-fluidr" style="max-width: 150px;"
                                                src="{{ asset($slider->image_url) }}" alt=""></td>
                                        <td><a href="">{{ $slider->status }}</a></td>
                                        <td>{{ $slider->created_by }}</td>
                                        <td>{{ $slider->created_at }}</td>
                                        <td class="text-center">
                                            @can('slider.delete')
                                                <a href="{{ route('admin.slider.delete', $slider->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"
                                                        onclick="return confirm('Bạn có chắc chắn xóa bản ghi này vĩnh viễn ?')"></i></a>
                                            @else
                                                <button class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    disabled data-toggle="tooltip" data-placement="top"
                                                    title="Bạn không có quyền xóa">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan
                                            @if ($slider->position > 1)
                                                <a href="{{ route('admin.slider.up', $slider->id) }}"
                                                    class="btn btn-info btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </a>
                                            @else
                                                <a href="" class="btn btn-info btn-sm rounded-0 text-white"
                                                    type="button" data-toggle="tooltip" data-placement="top" title="up"
                                                    style="pointer-events: none; opacity: 0.5;"><i
                                                        class="fas fa-arrow-up"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $sliders->links() }} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        show_upload_image = function() {
            var upload_image = document.getElementById("file-slider")
            if (upload_image.files && upload_image.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-slider').attr('src', e.target.result)
                };
                reader.readAsDataURL(upload_image.files[0]);
            }
        }
    </script>
@endsection
