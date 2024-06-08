@extends('welcome')

@section('content')
    <div class="home-slider">
        <div class="container">
            <div class="home-slider-row">
                <div class="slider-featured">
                    <div class="sliders">
                        @foreach ($sliders as $slider)
                            <div>
                                <img src="{{ asset($slider->image) }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="banner-featured">
                    <div class="item-banner">
                        <img src="{{ asset('uploads/sliders/bn1.webp') }}">
                    </div>
                    <div class="item-banner">
                        <img src="{{ asset('uploads/sliders/bn1.webp') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-best">
        <div class="container">
            <div class="home-best-slick">
                @foreach ($products as $product)
                    @include('frontend.partials.itemProduct', ['product' => $product])
                @endforeach

            </div>
        </div>
    </div>
    <div class="home-product">
        <div class="container">
            <div class="wrap-product">
                <header class="header-home">
                    <h3 class="title-home">Giày dép nam</h3>
                    <ul class="menu-header">
                        <li><a href="">Giày tây công sở</a></li>
                        <li><a href="">Giày sneaker</a></li>
                        <li><a href="">Giày lười</a></li>
                        <li><a href="">Giày mọi</a></li>
                        <li><a href="">Giày tăng chiều cao</a></li>
                        <li><a href="">Dép nam</a></li>
                        <li><a href="">Giày boot</a></li>
                    </ul>
                    <a class="all-header" href="{{ url('giay-dep-nam') }}">Xem tất cả</a>
                </header>
                <ul class="list-product">
                    @foreach ($products->take(10) as $product)
                        @php
                            $cate_slug = App\Models\Categories::find($product->cate_id)->slug;
                        @endphp
                        <li class="item-product">
                            <div class="row-product">
                                <a class="link-row-product" href="{{ url('product/'.$cate_slug.'/' . $product->slug.'.html') }}">
                                    <div class="image-row-product">
                                        <img class="thumb-row-product" src="{{ asset($product->thumbnail) }}">
                                    </div>
                                    <h2 class="name-row-product">{{ $product->name }}</h2>
                                    <div class="price-row-product">
                                        <span
                                            class="sale-row-product">{{ $product->sale_price }}<sup>đ</sup></span><del>{{ $product->product_price }}</del>
                                    </div>
                                    <span
                                        class="discount-row-product">-{{ 100 - ($product->sale_price / $product->product_price) * 100 }}%</span>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
