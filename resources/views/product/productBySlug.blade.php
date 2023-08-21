@extends('layouts.home')

@section('content')
    <div class="brand">
        <div class="container">
            <div class="brand__list">
                @foreach ($brandsWithProducts as $brand)
                    @php
                        $hasProducts = $brand->products->where('category_id', $category->id)->isNotEmpty();
                    @endphp

                    @if ($hasProducts)
                    <a href="{{ url('danh-muc/' . $category->slug . '?brand=' . $brand->slug) }}" class="brand__item">
                            <img src="{{ asset($brand->logo_path) }}" alt="">
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="breadcrumb__container">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('http://localhost/Laravelpro/ismart/') }}">
                                <i class="bi bi-house-door-fill"></i>
                                Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ url('danh-muc/'.$category->slug ) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @if (request()->has('brand'))
                            @php
                                $selectedBrand = $brandsWithProducts->firstWhere('slug', request('brand'));
                            @endphp
                            @if ($selectedBrand)
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="{{ url('danh-muc/' . $category->slug . '?brand=' . $selectedBrand->slug) }}">
                                        {{ $selectedBrand->name }}
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ol>
                </nav>
            </div>

            <div class="product__container">
                <div class="container">
                    <div id="title">
                        <p>
                            {{ $category->name }} 
                        </p>
                    </div>
                    
                    <div class="product__soft">
                        <select name="arrange" id="product__filter" class="form-control">
                            <option value="{{ url('danh-muc/' . $category->slug) }}">Giá</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?filter=duoi1tr') }}" {{ request('filter') === 'duoi1tr' ? 'selected' : '' }}>Dưới 1 triệu</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?filter=tu1den5tr') }}" {{ request('filter') === 'tu1den5tr' ? 'selected' : '' }}>Từ 1 đến 5 triệu</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?filter=tu5den10tr') }}" {{ request('filter') === 'tu5den10tr' ? 'selected' : '' }}>Từ 5 đến 10 triệu</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?filter=tu10den20tr') }}" {{ request('filter') === 'tu10den20tr' ? 'selected' : '' }}>Từ 10 dến 20 triệu</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?filter=tren20tr') }}" {{ request('filter') === 'tren20tr' ? 'selected' : '' }}>Trên 20 triệu</option>
                        </select>
        
                        <select name="arrange" id="product__arrange" class="form-control">
                            <option value="{{ url('danh-muc/' . $category->slug) }}">Sắp xếp</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?soft=asc') }}" {{ request('soft') === 'asc' ? 'selected' : '' }}>Từ A - Z</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?soft=desc') }}" {{ request('soft') === 'desc' ? 'selected' : '' }}>Từ Z - A</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?soft=tangdan') }}" {{ request('soft') === 'tangdan' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="{{ url('danh-muc/' . $category->slug . '?soft=giamdan') }}" {{ request('soft') === 'giamdan' ? 'selected' : '' }}>Giá giảm dần</option>
                        </select>
                    </div>

                    <div class="product__list">
                        @if ($filteredProducts->isEmpty())
                        <p>Cửa hàng không có sản phẩm nào phù hợp.</p>
                        @else
                        @foreach ($filteredProducts as $product)
                            <div class="product__item">
                                <div class="product__card" style="height: 380px">
                                    <div class="card__img">
                                        <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}">
                                            <img src="{{ asset($product->thumbnail_path) }}">
                                        </a>
                                    </div>
                                    <div class="card__info" style="height: 120px">
                                        <a href="{{ url('san-pham', ['slug' => Str::slug($product->product_name)]) }}" class="product__title" style="height: 100px">{{ $product->product_name }}</a>
                                        <p class="product__price new">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                        @if (isset($product->price_old))
                                            <p class="product__price old">{{ number_format($product->price_old, 0, ',', '.') }}đ</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterSelect = document.getElementById('product__filter');
            const arrangeSelect = document.getElementById('product__arrange');
    
            filterSelect.addEventListener('change', updateUrl);
            arrangeSelect.addEventListener('change', updateUrl);
    
            function updateUrl() {
                const selectedFilterValue = filterSelect.value;
                const selectedArrangeValue = arrangeSelect.value;
    
                const baseUrl = "{{ url('danh-muc/' . $category->slug) }}";
                const brandParam = "{{ request('brand') }}";

                const filterQuery = selectedFilterValue !== baseUrl ? `${selectedFilterValue.split('?')[1]}` : '';
                const arrangeQuery = selectedArrangeValue !== baseUrl ? `${selectedArrangeValue.split('?')[1]}` : '';
    
                const queryParams = [filterQuery, arrangeQuery].filter(query => query !== '').join('&');
                let newUrl = baseUrl;
                if (brandParam) {
                // Nếu có query parameter 'brand', thêm nó vào URL mới trước tất cả các query parameters khác
                    newUrl += `?brand=${brandParam}`;
                }
                if (queryParams) {
                    newUrl += `${brandParam ? '&' : '?'}${queryParams}`;
                }
                window.location.href = newUrl;
            }
        });
    </script>
    
@endsection
