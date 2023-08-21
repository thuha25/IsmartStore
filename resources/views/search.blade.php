@foreach($data as $pro)
<li>
    <a href="{{ route('showDetailProduct', ['slug' => $pro->slug]) }}" class="card__img">
        <img src="{{ asset($pro->thumbnail_path) }}" alt="">
    </a>
    <div class="card__info">
        <a href="{{ route('showDetailProduct', ['slug' => $pro->slug]) }}" class="card__name">{{$pro->product_name}}</a>
        <p class="card__price">{{ number_format($pro->product_price, 0, ',', '.') }}đ</p>
    </div>
</li>
@endforeach