@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="text" class="form-control form-search" name="keyword"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/post/action') }}" method="">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        @can('page.delete')
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        @else
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary" disabled>
                        @endcan
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($posts->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($posts as $post)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $post->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td><img class="rounded border" style="height: 60px; width:60px; object-fit: cover;"
                                                src="{{ asset($post->thumbnail_path) }}" alt=""></td>
                                        <td><a
                                                href="{{ route('admin.post.editPost', $post->id) }}">{{ $post->title }}</a>
                                        </td>
                                        <td>
                                            @foreach ($post->categories as $category)
                                                {{ $category->name }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $post->state }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>
                                            @can('post.delete', 'post.edit')
                                                <a href="{{ route('admin.post.editPost', $post->id) }}"
                                                    class="btn btn-success mb-2 btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_post', $post->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('admin.post.editPost', $post->id) }}"
                                                    class="btn btn-success mb-2 btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_post', $post->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="bg-white">Không tìm thấy trang nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $posts->links() }}
                </form>
            </div>
        </div>
    </div>
@endsection
