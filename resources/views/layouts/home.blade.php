<!DOCTYPE html>
<html lang="en">
<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link href="{{ asset('/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/main.js') }}" type="text/javascript"></script>
</head>
<body>
    <div class="header-nav header_nav_fix">
        <div class="container">
            <ul>
                @foreach ($cat_products as $cat_product)
                    <li>
                        @if ($cat_product->name === 'Điện thoại')
                            <a href="{{ url('danh-muc/dien-thoai') }}"><i class="bi bi-phone"></i>
                        @elseif ($cat_product->name === 'Laptop')
                            <a href="{{ url('danh-muc/laptop') }}"><i class="bi bi-laptop"></i>
                        @elseif ($cat_product->name === 'Phụ kiện')
                            <a href="{{ url('danh-muc/phu-kien') }}"><i class="bi bi-headphones"></i>
                        @elseif ($cat_product->name === 'Máy tính bảng')
                            <a href="{{ url('danh-muc/may-tinh-bang') }}"><i class="bi bi-tablet"></i>
                        @elseif ($cat_product->name === 'Tai nghe')
                            <a href="{{ url('danh-muc/tai-nghe') }}"><i class="bi bi-earbuds"></i>
                        @elseif ($cat_product->name === 'Smartwatch')
                            <a href="{{ url('danh-muc/smartwatch') }}"><i class="bi bi-smartwatch"></i>
                        @elseif ($cat_product->name === 'SmartTV')
                            <a href="{{ url('danh-muc/smarttv') }}"><i class="bi bi-tv"></i>
                        @endif
                        <span>{{ $cat_product->name }}</span>
                        </a>
                        @php
                            $filteredProducts = $brandsWithProducts->flatMap(function ($brand) use ($cat_product) {
                                return $brand->products->filter(function ($product) use ($cat_product) {
                                    return $product->category->name === $cat_product->name;
                                });
                            });
                        @endphp
                        @if ($filteredProducts->isNotEmpty())
                            <ul class="sub_menu">
                                @foreach ($brandsWithProducts as $brand)
                                    @php
                                        $brandProducts = $brand->products->filter(function ($product) use ($cat_product) {
                                            return $product->category->name === $cat_product->name;
                                        });
                                    @endphp
                                    @if ($brandProducts->isNotEmpty())
                                        <li>
                                            <a
                                                href="{{ url('danh-muc/' . Str::slug($cat_product->name) . '?brand=' . $brand->slug) }}">
                                                <span>{{ $brand->name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <header>
        <div class="header-top">
            <div class="container">
                <ul>
                    <li>
                        <a href="{{ route('home') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ url('http://localhost/Laravelpro/ismart/tin-tuc') }}" title="">Tin tức</a>
                    </li>
                    <li>
                        <a href="{{ url('http://localhost/Laravelpro/ismart/gioi-thieu') }}" title="">Giới thiệu</a>
                    </li>
                    <li>
                        <a href="{{ url('http://localhost/Laravelpro/ismart/lien-he') }}" title="">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header-body">
            <div class="container ">
                <a href="{{ route('home') }}" class="header__logo">
                    <img src="{{ asset('/images/logo.png') }}" alt="">
                </a>
                <div class="header__search">
                    {!! Form::open([
                        'url' => 'http://localhost/Laravelpro/ismart/tim-kiem',
                        'method' => 'GET',
                        'class' => 'd-flex',
                    ]) !!}
                    {!! Form::text('s', '', [
                        'class' => 'product__search',
                        'placeholder' => 'Bạn tìm gì...',
                        'autocomplete' => 'off',
                    ]) !!}
                    <button>
                        <i class="bi bi-search"></i>
                    </button>
                    {!! Form::close() !!}
                    <ul class="result__search">

                    </ul>
                </div>
                <div class="header__action">
                    <div class="header__advise">
                        <div class="header__advise__icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="header__advise__phone">
                            <p>Tư vấn</p>
                            <p>0988.274.803</p>
                        </div>
                    </div>
                    <div id="cart-wp" class="fl-right">
                        <div id="btn-cart">
                            <a href="{{ route('cart.show') }}" class="text-light header_cart">
                                <i id="trash-header" class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">{{ Cart::count() }}</span>
                            </a>
                        </div>
                        @if (Cart::count() > 0)
                            <div id="dropdown">
                                <p class="desc">Có <span>{{ Cart::count() }} sản phẩm</span> trong giỏ hàng</p>
                                <ul class="list-cart">
                                    @foreach ($cat as $row)
                                        <li class="clearfix">
                                            <a href="{{ url('san-pham', ['slug' => Str::slug($row->name)]) }}"
                                                title="" class="thumb fl-left">
                                                <img src="{{ asset($row->options->thumbnail) }}" alt="">
                                            </a>
                                            <div class="info fl-right">
                                                <a href="{{ url('san-pham', ['slug' => Str::slug($row->name)]) }}"
                                                    title="" class="product-name">{{ $row->name }}</a>
                                                <p class="price mb-0"> {{ number_format($row->price, 0, ',', '.') }}đ
                                                </p>
                                                <p class="qty mb-0">Màu: <span>{{ $row->options->color }}</span></p>
                                                <p class="qty mb-0">Số lượng: <span>{{ $row->qty }}</span></p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="total-price clearfix">
                                    <p class="title fl-left mb-0">Tổng:</p>
                                    <p class="price fl-right mb-0">{{ Cart::total() }}đ<span
                                            class="text-lowercase">đ</span></p>
                                </div>
                                <div class="action-cart clearfix">
                                    <a href="{{ route('cart.show') }}" title="Giỏ hàng"
                                        class="view-cart fl-left">Giỏ hàng</a>
                                    <a href="{{ route('checkout') }}" title="Thanh toán"
                                        class="checkout fl-right">Thanh toán</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="header-nav">
            <div class="container">
                <ul>
                    @foreach ($cat_products as $cat_product)
                        <li>
                            @if ($cat_product->name === 'Điện thoại')
                                <a href="{{ url('danh-muc/dien-thoai') }}">
                                    <i class="bi bi-phone"></i>
                                @elseif ($cat_product->name === 'Laptop')
                                    <a href="{{ url('danh-muc/laptop') }}">
                                        <i class="bi bi-laptop"></i>
                                    @elseif ($cat_product->name === 'Phụ kiện')
                                        <a href="{{ url('danh-muc/phu-kien') }}">
                                            <i class="bi bi-headphones"></i>
                                        @elseif ($cat_product->name === 'Máy tính bảng')
                                            <a href="{{ url('danh-muc/may-tinh-bang') }}">
                                                <i class="bi bi-tablet"></i>
                                            @elseif ($cat_product->name === 'Tai nghe')
                                                <a href="{{ url('danh-muc/tai-nghe') }}">
                                                    <i class="bi bi-earbuds"></i>
                                                @elseif ($cat_product->name === 'Smartwatch')
                                                    <a href="{{ url('danh-muc/smartwatch') }}">
                                                        <i class="bi bi-smartwatch"></i>
                                                    @elseif ($cat_product->name === 'SmartTV')
                                                        <a href="{{ url('danh-muc/smarttv') }}">
                                                            <i class="bi bi-tv"></i>
                            @endif
                            <span>{{ $cat_product->name }}</span>
                            </a>
                            @php
                                $filteredProducts = $brandsWithProducts->flatMap(function ($brand) use ($cat_product) {
                                    return $brand->products->filter(function ($product) use ($cat_product) {
                                        return $product->category->name === $cat_product->name;
                                    });
                                });
                            @endphp
                            @if ($filteredProducts->isNotEmpty())
                                <ul class="sub_menu">
                                    @foreach ($brandsWithProducts as $brand)
                                        @php
                                            $brandProducts = $brand->products->filter(function ($product) use ($cat_product) {
                                                return $product->category->name === $cat_product->name;
                                            });
                                        @endphp
                                        @if ($brandProducts->isNotEmpty())
                                            <li>
                                                <a
                                                    href="{{ url('danh-muc/' . Str::slug($cat_product->name) . '?brand=' . $brand->slug) }}">
                                                    <span>{{ $brand->name }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
    <div id="main-content-wp" class="checkout-page">
        @yield('content')
    </div>
    <footer>
        <div class="container">
            <div class="footer__content">
                <div class="footer__item">
                    <div class="block" id="info-company">
                        <h3 class="title">ISMART</h3>
                        <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng,
                            chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                        <div id="payment">
                            <div class="thumb">
                                <img src="{{ asset('/images/img-foot.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Thông tin cửa hàng</h3>
                    </div>
                    <ul class="footer__body">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>57 Nguyễn Sinh Sắc - Hoà Minh - Liên Chiểu - Đà Nẵng</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <span>0988.274.803 - 0989.989.989</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <span>vshop@gmail.com</span>
                        </li>
                    </ul>
                </div>
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Chính sách mua hàng</h3>
                    </div>
                    <ul class="footer__body">
                        <li>
                            <a href="">Quy định - chính sách</a>
                        </li>
                        <li>
                            <a href="">Chính sách bảo hành - đổi trả</a>
                        </li>
                        <li>
                            <a href="">Chính sách hội viện</a>
                        </li>
                        <li>
                            <a href="">Giao hàng - lắp đặt</a>

                        </li>
                    </ul>
                </div>
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Bảng tin</h3>
                    </div>
                    <ul class="footer__body">
                        <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                        <div id="form-reg">
                            {!! Form::open([
                                'name' => 'form-checkout',
                                'url' => route('regis'),
                                'method' => 'POST',
                            ]) !!}
                            <div class="form-group">
                                {!! Form::text('email', '', [
                                    'class' => 'form-control',
                                    'id' => 'email',
                                    'placeholder' => 'Nhập email tại đây',
                                ]) !!}
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Đăng ký', [
                                    'id' => 'sm-reg',
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            CỬA HÀNG ISMART
        </div>
    </footer>
    <div id="back_to_top">
        <a href="#">
            <i class="bi bi-caret-up-fill"></i>
        </a>
    </div>
    <div id="notification__cart">
        <div class="notification__modal">
            <div class="notification__icon">
                <i class="bi bi-check2"></i>
            </div>
            <div class="notification__title">
                <h1>Đã thêm vào giỏ hàng</h1>
            </div>
            <div class="notification__footer">
                <div class="notification__close">
                    Đóng
                </div>
                <a href="{{ route('cart.show') }}" class="notification__buy">
                    Giỏ hàng
                </a>
            </div>
        </div>
    </div>
    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- BOOSTRAP JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CAROUSEL JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        $('.product__search').keyup(function() {
            var _text = $(this).val();
            var _url = "{{ url('public') }}"
            var url = "{{ url('') }}"
            if (_text != '') {
                $.ajax({
                    url: "{{ route('search_product') }}?key=" + _text,
                    type: 'GET',
                    success: function(res) {
                        $('.result__search').html(res);
                        if (res.trim() === '') {
                            $('.result__search').html(
                                '<li class="no-result">Không tìm thấy sản phẩm nào.</li>');
                        }
                        if (_text.trim() !== '') {
                            $('.result__search').css('display', 'block');
                        } else {
                            $('.result__search').css('display', 'none');
                        }
                    }
                });
            } else {
                $('.result__search').html('');
                $('.result__search').hide();
            }
            // alert(_text);
        })

        $('.product__add_cart').click(function() {
            let color_element = $(".color__item.active");
            if (color_element.length > 0) {
                let color_id = color_element.attr("data-id");
                let product_id = $(this).attr("data-id");
                // alert(color_id);
                // alert(product_id);
                $.ajax({
                    url: "{{ route('cart.add') }}?product_id=" + product_id + "&color_id" + color_id,
                    type: 'GET',
                    data: {
                        product_id,
                        color_id
                    },
                    success: function(data) {
                        $(".header_cart span#num").html(data);
                        $("#notification__cart").css("display", "flex");
                    }
                });
            } else {
                $(".color__err").css("display", "block");
            }
        });
        $(document).on("click", ".notification__close", function() {
            $("#notification__cart").css("display", "none");
        });

        $(".product__buy").click(function(event) {
            event.preventDefault();
            let color_element = $(".color__item.active");
            if (color_element.length <= 0) {
                $(".color__err").css("display", "block");
            } else {
                const color_id = color_element.attr("data-id");
                const product_id = $(this).attr("data-id");
                const url = $(".product__buy").attr("href");
                // console.log(url);
                $.ajax({
                    url: "{{ route('cart.add') }}?product_id=" + product_id + "&color_id" + color_id,
                    method: "GET",
                    data: {
                        product_id,
                        color_id
                    },
                    success: function(data) {
                        console.log(data);
                        window.location = url;
                    },
                });
            }
        });

        var increase_eles = document.querySelectorAll(".increase");
        var decrease_eles = document.querySelectorAll(".decrease");
        if (increase_eles) {
            increase_eles.forEach((ele) => {
                ele.addEventListener("click", function(e) {
                    let product_id = e.target.getAttribute("data-id");
                    let qty = parseInt(
                        document.querySelector(`.product_${product_id}`).value
                    );
                    qty += 1;
                    document.querySelector(`.product_${product_id}`).value = qty;
                    $.ajax({
                        url: "{{ route('cart.update') }}",
                        method: "GET",
                        data: {
                            product_id,
                            qty
                        },
                        success: function(data) {
                            $(".header_cart span#num").html(data);
                            $(".sub_total_" + product_id).html(data.cart[product_id]);
                            $(".cart__total-span").html(data["total"] + "đ");
                            $(".header_cart span#num").html(data["count"]);
                            // console.log(data);
                        },
                    });
                });
            });
        }
        if (decrease_eles) {
            decrease_eles.forEach((ele) => {
                ele.addEventListener("click", function(e) {
                    let product_id = e.target.getAttribute("data-id");
                    let qty = parseInt(
                        document.querySelector(`.product_${product_id}`).value
                    );
                    if (qty > 1) {
                        qty -= 1;
                        document.querySelector(`.product_${product_id}`).value = qty;
                        $.ajax({
                            url: "{{ route('cart.update') }}",
                            method: "GET",
                            data: {
                                product_id,
                                qty
                            },
                            success: function(data) {
                                $(".sub_total_" + product_id).html(data.cart[product_id]);
                                $(".cart__total-span").html(data["total"] + "đ");
                                $(".header_cart span#num").html(data["count"]);
                                // console.log(data);
                            },
                        });
                    }
                });
            });
        }
    </script>
</body>

</html>
