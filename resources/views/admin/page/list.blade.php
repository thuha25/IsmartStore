@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">DANH SÁCH TRANG</h5>
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
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary"> Công khai<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <form action="{{ url('admin/page/action') }}" method="">
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
                                <th scope="col">Tên trang</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pages->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($pages as $page)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $page->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td><a href="{{ route('page.edit', $page->id) }}">{{ $page->name_page }}</a></td>
                                        <td><a href="{{ route('page.edit', $page->id) }}">{{ $page->title }}</a></td>
                                        <td>{{ $page->state }}</td>
                                        <td>{{ $page->user->name }}</td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>
                                            @can('page.delete','page.edit')
                                                <a href="{{ route('page.edit', $page->id) }}"
                                                    class="btn btn-success mb-2 btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_page', $page->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                    class="btn btn-danger mb-2 btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('page.edit', $page->id) }}"
                                                    class="btn btn-success mb-2 btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit" disabled><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_page', $page->id) }}"
                                                    class="btn btn-danger mb-2 btn-sm rounded-0 text-white" type="button"
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
                    {{ $pages->links() }}
                </form>
            </div>
        </div>
    </div>
@endsection
