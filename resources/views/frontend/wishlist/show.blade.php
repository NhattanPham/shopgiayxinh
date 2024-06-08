@extends('welcome')

@section('content')
    <div class="home-product">
        <div class="container">
            <div class="uk-overflow-container">
                @if ($products != null )
                    <table class="uk-table">
                        <thead>
                            <tr>
                                <th>Hình</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img style="width: 80px; height:80px" src="{{ asset($product->thumbnail) }}"
                                        alt="Not found">
                                </td>
                                <td class="uk-text-middle">
                                    {{ $product->name }}
                                </td>
                                <td class="uk-text-middle">
                                    {{ $product->sale_price }}
                                </td>
                                <td class="uk-text-middle">
                                    <button class="uk-button">X</button>
                                    <button class="uk-button">Add to Cart</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <h3>Không có sản phẩm yêu thích</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
