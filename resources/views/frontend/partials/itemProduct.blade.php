@php
    $cate_slug = App\Models\Categories::find($product->cate_id)->slug;
@endphp
<div class="item-product">
    <div class="row-product">
        <a class="link-row-product" href="{{ url( $cate_slug.'/' . $product->slug.'.html') }}">
            <div class="image-row-product">
                <img class="thumb-row-product" src="{{ asset($product->thumbnail) }}">
            </div>
            <h2 class="name-row-product">{{ $product->name }}</h2>
            <div class="price-row-product">
                <span
                    class="sale-row-product">{{ number_format($product->sale_price, 0, ',', '.') }}<sup>đ</sup></span><del>{{ number_format($product->product_price, 0, ',', '.') }}<sup>đ</sup></del>
            </div>
            <span class="discount-row-product">-{{ 100-($product->sale_price/$product->product_price*100) }}%</span>
        </a>
    </div>
</div>
