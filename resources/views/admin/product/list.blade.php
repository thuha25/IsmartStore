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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="text" class="form-control form-search" name="keyword"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm" autocomplete="off">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'stocking']) }}" class="text-primary">Còn hàng<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'outofstock']) }}" class="text-primary">Hết
                        hàng<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <form action="{{ url('admin/product/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id=""name="act">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        @can('product.delete')
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
                                <th scope="col">Stt</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($products as $product)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $product->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td><img class="rounded border" style="height: 60px; width:60px; object-fit: cover;"
                                                src="{{ asset($product->thumbnail_path) }}" alt=""></td>
                                        <td><a
                                                href="{{ route('admin.product.editProduct', $product->id) }}">{{ $product->product_name }}</a>
                                        </td>
                                        <td>{{ $product->product_price }}</td>
                                        <td>
                                            {{ $product->category->name }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge 
                                                @if ($product->status === 'Còn hàng') badge-success
                                                @elseif ($product->status === 'Hết hàng') badge-dark @endif">
                                                {{ $product->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product.editProduct', $product->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete_product', $product->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn xoá bản ghi này?')"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                            <span class="mt-md-1 d-md-block d-xl-inline-block"><a
                                                    href="{{ route('admin.product.add_img', $product->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Thêm hình ảnh"><i
                                                        class="fa fa-plus-circle" aria-hidden="true"></i></a></span>
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
                    {{ $products->links() }}
                </form>
            </div>
        </div>
    </div>
@endsection
