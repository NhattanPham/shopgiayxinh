@extends('welcome')

@section('content')
    <div class="home-product product-with-category">
        <div class="container">
            <h2>{{ $category->name }}</h2>
            <div class="filter">
                <strong>Sắp xếp theo: </strong>
                <ul>
                    <li class="{{ request()->input('orderBy') == 'name ASC' ? 'active' : '' }}"><a
                            href="{{ url($slug . '?orderBy=name%20ASC') }}"><i
                                class="{{ request()->input('orderBy') == 'name ASC' ? 'uk-icon-dot-circle-o' : 'uk-icon-circle-o' }}"></i>
                            Tên A-Z</a></li>
                    <li class="{{ request()->input('orderBy') == 'name DESC' ? 'active' : '' }}"><a
                            href="{{ url($slug . '?orderBy=name%20DESC') }}"><i
                                class="{{ request()->input('orderBy') == 'name DESC' ? 'uk-icon-dot-circle-o' : 'uk-icon-circle-o' }}"></i>
                            Tên Z-A</a></li>
                    <li class="{{ request()->input('orderBy') == 'created DESC' ? 'active' : '' }}"><a
                            href="{{ url($slug . '?orderBy=created%20DESC') }}"><i
                                class="{{ request()->input('orderBy') == 'created DESC' ? 'uk-icon-dot-circle-o' : 'uk-icon-circle-o' }}"></i>
                            Mới nhất</a></li>
                    <li class="{{ request()->input('orderBy') == 'sale_price ASC' ? 'active' : '' }}"><a
                            href="{{ url($slug . '?orderBy=sale_price%20ASC') }}"><i
                                class="{{ request()->input('orderBy') == 'sale_price ASC' ? 'uk-icon-dot-circle-o' : 'uk-icon-circle-o' }}"></i>
                            Giá thấp đến cao</a></li>
                    <li class="{{ request()->input('orderBy') == 'sale_price DESC' ? 'active' : '' }}"><a
                            href="{{ url($slug . '?orderBy=sale_price%20DESC') }}"><i
                                class="{{ request()->input('orderBy') == 'sale_price DESC' ? 'uk-icon-dot-circle-o' : 'uk-icon-circle-o' }}"></i>
                            Giá cao đến thấp</a></li>
                </ul>
            </div>
            <div class="wrap-product">
                <ul class="grid-show-product">
                    @foreach ($products as $product)
                        <li class="">
                            @include('frontend.partials.itemProduct', ['product' => $product])
                        </li>
                    @endforeach
                </ul>
            </div>
            {{ $products->appends(request()->all())->links('frontend.partials.custom-pagination', ['data' => $products]) }}
        </div>
    </div>
@endsection
