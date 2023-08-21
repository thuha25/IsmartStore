@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thêm màu
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'url' => 'http://localhost/Laravelpro/ismart/admin/product/product-color/add_color',
                            'method' => 'POST',
                            'files' => true,
                        ]) !!}
                        <div class="form-group">
                            {!! Form::label('color_name', 'Tên màu') !!}
                            {!! Form::text('color_name', '', ['class' => 'form-control', 'id' => 'color_name', 'autocomplete' => 'off']) !!}
                            @error('color_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('colorpicker', 'Chọn màu') !!}
                            {!! Form::color('color_select', '', [
                                'class' => 'form-control',
                                'id' => 'colorpicker',
                                'value' => '#000000',
                                'oninput' => 'updateColorCode()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('hexcolor', 'Mã màu') !!}
                            {!! Form::text('color_code', null, [
                                'class' => 'form-control text-center',
                                'id' => 'hexcolor',
                                'style' => 'font-weight: 700; text-transform: uppercase',
                                'disabled' => true
                            ]) !!}
                            {!! Form::hidden('color_code_hidden', null, ['id' => 'color_code_hidden']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::button('Thêm mới', [
                                'name' => 'btn-add-color',
                                'class' => 'btn btn-primary',
                                'type' => 'submit',
                                'value' => 'Thêm mới',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách màu
                    </div>
                    <div class="card-body" style="min-height: 500px">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Mã màu</th>
                                    <th scope="col">Hiển thị</th>
                                    <th scope="col" class="text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($colors as $color)
                                    @php
                                        $t++;
                                    @endphp
                                     <tr>
                                        <th scope="row">{{ $t }}</th>
                                        <td>{{ $color->color_name }}</td>
                                        <td><span class="text-uppercase">{{ $color->color_code }}</span></td>
                                        <td>
                                            <div
                                                style="width: 100px;height: 20px; border: 1px solid gray; background-color: {{ $color->color_code }}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.product.deleteColor', $color->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"
                                                    onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $colors->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateColorCode() {
            // Get the selected color from the color picker
            const colorPicker = document.getElementById('colorpicker');
            const selectedColor = colorPicker.value;
            // Update the value of the "Mã màu" input field
            const colorCodeInput = document.getElementById('hexcolor');
            colorCodeInput.value = selectedColor;
            const colorCodeHidden = document.getElementById('color_code_hidden');
            colorCodeHidden.value = selectedColor;
        }
    </script>
@endsection
