@extends('welcome')
@section('content')
    <div class="home-product">
        <div class="container">
            <div class="uk-overflow-container">
                <table class="uk-table">
                    <thead>
                        <tr>
                            <th>Hình</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            {{-- <th>Hành động</th> --}}
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($carts as $cart)
                        @php
                            $product = App\Models\Product::find($cart->product_id);
                            $total += $product->sale_price*$cart->quantity;
                        @endphp
                        <tr>
                            <td>
                                <img style="width: 80px; height:80px" src="{{ asset($product->thumbnail) }}" alt="Not found">
                            </td>
                            <td class="uk-text-middle">
                                {{ $product->name }} <br>
                                {{ $cart->color }}, {{ $cart->size }}
                            </td>
                            <td class="uk-text-middle">
                                <span class="product-price">
                                    {{ number_format($product->sale_price, 0, ',', '.') }}
                                </span> đ
                            </td>
                            <td class="uk-text-middle">
                                <div class="quantity">
                                    {{-- <button class="uk-button decrease">-</button> --}}
                                    <span>{{ $cart->quantity }}</span>
                                    {{-- <button class="uk-button increase">+</button> --}}
                                </div>
                            </td>
                            <td class="uk-text-middle">
                                <span class="total-price">
                                    {{ number_format($product->sale_price * $cart->quantity, 0, ',', '.') }}
                                </span> đ
                            </td>
                            <input type="hidden" class="product_id" value="{{ $cart->product_id }}">
                            <input type="hidden" class="color" value="{{ $cart->color }}">
                            <input type="hidden" class="size" value="{{ $cart->size }}">
                        </tr>
                    @endforeach
                </table>
            </div>
            <hr>
            <form action="{{ url('/checkout') }}" method="POST" class="uk-form">
                @csrf
                <div class="uk-flex uk-flex-right">
                    <hr>
                    <div style="width:30%">
                        <div class="uk-flex uk-flex-space-between">
                            <span>Tổng tiền hàng: </span>
                            <div><span id="total">{{ $total }}</span> đ</div>

                        </div>
                        <div class="uk-flex uk-flex-space-between">
                            <span>Phí vận chuyển:</span>
                            <div><span id="ship">300000</span> đ</div>

                        </div>
                        <hr>
                        <div class="uk-flex uk-flex-space-between">
                            <span>Tổng thanh toán:</span>
                            <div><span id="total-all"></span> đ</div>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="infor-user">
                    <strong>THÔNG TIN VẬN CHUYỂN</strong>
                    <div class="uk-grid">
                        <div class="uk-width-1-4">
                            <input class="uk-width-1-1" type="text" name="name"
                                value="{{ Auth::check() ? Auth::user()->name : '' }}">
                        </div>
                        <div class="uk-width-2-4">
                            <input class="uk-width-1-1" type="text" name="email"
                                value="{{ Auth::check() ? Auth::user()->email : '' }}">
                        </div>
                        <div class="uk-width-1-4">
                            <input class="uk-width-1-1" type="number" name="phone"
                                value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <textarea class="uk-width-1-1" name="address" id="" rows="5" placeholder="Địa chỉ nhận hàng"></textarea>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-3">
                            <select class="uk-width-1-1" name="province" id="province">
                                <option value="0">Chọn Tỉnh/Thành phố</option>
                            </select>
                        </div>
                        <div class="uk-width-1-3">
                            <select class="uk-width-1-1" name="district" id="district">
                                <option value="0">Chọn Quận/Huyện</option>
                            </select>
                        </div>
                        <div class="uk-width-1-3">
                            <select class="uk-width-1-1" name="ward" id="ward">
                                <option value="0">Chọn Phường/Xã</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="uk-text-right checkout">
                    <button class="uk-button button-buy">Đặt hàng</button>
                </div>
                <input type="hidden" name="isInCart" value="{{ $isInCart }}">
            </form>
        </div>
    </div>
@endsection
