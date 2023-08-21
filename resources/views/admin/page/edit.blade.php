@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa Trang
            </div>
            <div class="card-body">
                {!! Form::open([
                    'url' =>  route('page.update', $page->id),
                    'method' => 'POST',
                    'files' => true,
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name_page', 'Tên trang') !!}
                    {!! Form::text('name_page', $page->name_page , ['class' => 'form-control', 'id' => 'slug' ,'readonly' => 'readonly','onkeyup' => 'ChangeToSlug()']) !!}
                    @error('name_page')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    {!! Form::label('slug', 'Slug link rút gọn') !!}
                    {!! Form::text('slug',  $page->slug, ['class' => 'form-control','readonly' => 'readonly','id'=>'convert_slug']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('title', 'Tiêu đề trang') !!}
                    {!! Form::text('title',  $page->title, ['class' => 'form-control']) !!}
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('content', 'Nội dung chi tiết') !!}
                    {!! Form::textarea('content',  $page->content, ['class' => 'form-control']) !!}
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('state', 'Trạng thái') !!}
                    <div class="form-check">
                        {!! Form::radio('state', 'Chờ duyệt', $page->state === 'Chờ duyệt', ['class' => 'form-check-input', 'id' => 'pending']) !!}
                        {!! Form::label('pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                    </div>
                    <div class="form-check">
                        {!! Form::radio('state', 'Công khai', $page->state === 'Công khai', ['class' => 'form-check-input', 'id' => 'publish']) !!}
                        {!! Form::label('publish', 'Công khai', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::button('Cập nhật', [
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
