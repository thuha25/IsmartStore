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
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    <div class="card-body">
                        {!! Form::open([
                            'url' => 'http://localhost/Laravelpro/ismart/admin/post/cat/store',
                            'method' => 'POST',
                            'files' => true,
                        ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Tên danh mục') !!}
                            {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'slug', 'onkeyup' => 'ChangeToSlug()']) !!}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug link rút gọn') !!}
                            {!! Form::text('slug', '', ['class' => 'form-control', 'id' => 'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('parent_cat', 'Danh mục cha') !!}
                                {!! Form::select(
                                    'parent_cat',
                                    [
                                        '0' => 'Không có',
                                        '1' => 'Đánh giá',
                                        '2' => 'Game/App',
                                        '3' => 'Khuyến mãi',
                                        '4' => 'Mẹo hay',
                                        '5' => 'Sản phẩm mới',
                                        '6' => 'Sự kiện',
                                        '7' => 'Tư vấn',
                                    ],
                                    '',
                                    ['class' => 'form-control', 'placeholder' => 'Chọn danh mục'],
                                ) !!}
                                @error('parent_cat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('state', 'Trạng thái') !!}
                            <div class="form-check">
                                {!! Form::radio('state', 'Chờ duyệt', 'checked', ['class' => 'form-check-input', 'id' => 'pending']) !!}
                                {!! Form::label('pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                            </div>
                            <div class="form-check">
                                {!! Form::radio('state', 'Công khai', '', ['class' => 'form-check-input', 'id' => 'publish']) !!}
                                {!! Form::label('publish', 'Công khai', ['class' => 'form-check-label']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::button('Thêm mới', [
                                'name' => 'btn-add',
                                'class' => 'btn btn-primary',
                                'type' => 'submit',
                                'value' => 'addPage',
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
                        Danh mục
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($posts as $post)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $t }}</th>
                                        <td>{{ $post->name }}</td>
                                        <td>{{ $post->slug }}</td>
                                        <td>
                                            <a href="{{route('admin.post.editCat', $post->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete_catpost', $post->id) }}" onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function ChangeToSlug() {
            var slug;
            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
@endsection
