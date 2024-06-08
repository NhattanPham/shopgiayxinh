@extends('welcome')

@section('content')
    <div class="home-product">
        <div class="container">
            <div class="uk-overflow-container">
                @if ($carts != null)
                <table class="uk-table">
                    <thead>
                        <tr>
                            <th>Hình</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    @foreach ($carts as $cart)
                        @php
                            $product = App\Models\Product::find($cart->product_id);
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
                                    <button class="uk-button decrease">-</button>
                                    <input type="number" class="input-quantity" value="{{ $cart->quantity }}">
                                    <button class="uk-button increase">+</button>
                                </div>
                            </td>
                            <td class="uk-text-middle">
                                <span class="total-price">
                                    {{ number_format($product->sale_price * $cart->quantity, 0, ',', '.') }}
                                </span> đ
                            </td>
                            <td class="uk-text-middle">
                                <form action="{{ url('cart') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="uk-button"><i class="uk-icon-close"></i></button>
                                    <input type="hidden" name="product_id" value="{{ $cart->product_id }}">
                                    <input type="hidden" name="color" value="{{ $cart->color }}">
                                    <input type="hidden" name="size" value="{{ $cart->size }}">
                                </form>
                            </td>
                            <input type="hidden" class="product_id" value="{{ $cart->product_id }}">
                            <input type="hidden" class="color" value="{{ $cart->color }}">
                            <input type="hidden" class="size" value="{{ $cart->size }}">
                        </tr>
                    @endforeach
                </table>
                <div class="order">
                    Tổng tiền hàng: <span id="total"></span> đ<br>
                    <a style="margin-top:20px;" class="uk-button button-buy" href="{{ url('/checkout')}}">Mua hàng</a>
                </div>
                @else
                    <h3>Giỏ hàng trống</h3>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                updateTotalPrice();
                var increaseButtons = document.querySelectorAll('.increase');
                var decreaseButtons = document.querySelectorAll('.decrease');
                var inputQuantitys = document.querySelectorAll('.input-quantity');

                // Duyệt qua tất cả các nút tăng và thêm sự kiện click
                increaseButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        updateQuantity(button, 1);
                    });
                });

                // Duyệt qua tất cả các nút giảm và thêm sự kiện click
                decreaseButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        updateQuantity(button, -1);
                    });
                });
                //Duyệt qua tất cả các input và thêm sự kiện onchange
                inputQuantitys.forEach(function(input) {
                    input.addEventListener('change', function() {
                        // Lấy đối tượng hàng chứa sản phẩm
                        var row = this.closest('tr');
                        // Lấy giá sản phẩm từ span.product-price
                        var price = parseFloat(row.querySelector('.product-price').textContent.split(
                            '.').join(''));
                        var quantity = this.value;
                        if (quantity < 1)
                            return;
                        // Tính toán tổng giá tiền mới
                        var newTotalPrice = price * quantity;

                        // Cập nhật tổng giá tiền trong span.total-price
                        row.querySelector('.total-price').textContent = newTotalPrice.toLocaleString(
                            'it-IT');
                        updateTotalPrice();
                        var token = '{{ csrf_token() }}';
                        var formData = new FormData();
                        var product_id = row.querySelector('.product_id').value;
                        var color = row.querySelector('.color').value;
                        var size = row.querySelector('.size').value;
                        console.log(product_id, color, size);
                        formData.append('product_id', product_id);
                        formData.append('color', color);
                        formData.append('size', size);
                        formData.append('quantity', quantity);
                        $.ajax({
                            type: 'POST',
                            url: '{{ url("/cart/updateQuantity") }}',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                console.log(response.success, response.data);
                            },
                            error: function(error) {
                                console.log(error.responseJSON);
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    })
                });

                function updateQuantity(button, change) {
                    // Lấy đối tượng hàng chứa sản phẩm
                    var row = button.closest('tr');
                    // Lấy giá sản phẩm từ span.product-price
                    var price = parseFloat(row.querySelector('.product-price').textContent.split('.').join(''));
                    // Lấy số lượng hiện tại từ input.input-quantity
                    var quantityInput = row.querySelector('.input-quantity');
                    var currentQuantity = parseInt(quantityInput.value);

                    // Tính toán số lượng mới
                    var newQuantity = currentQuantity + change;

                    // Đảm bảo số lượng không nhỏ hơn 1
                    if (newQuantity < 1) {
                        return;
                    }

                    // Cập nhật số lượng trong input.input-quantity
                    quantityInput.value = newQuantity;

                    // Tính toán tổng giá tiền mới
                    var newTotalPrice = price * newQuantity;

                    // Cập nhật tổng giá tiền trong span.total-price
                    row.querySelector('.total-price').textContent = newTotalPrice.toLocaleString('it-IT');

                    // Tính toán tổng giá tiền của tất cả các sản phẩm và cập nhật giá trị này trên giao diện
                    updateTotalPrice();
                    var token = '{{ csrf_token() }}';
                    var formData = new FormData();
                    var product_id = row.querySelector('.product_id').value;
                    var color = row.querySelector('.color').value;
                    var size = row.querySelector('.size').value;
                    console.log(product_id, color, size);
                    formData.append('product_id', product_id);
                    formData.append('color', color);
                    formData.append('size', size);
                    formData.append('quantity', newQuantity);
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('/cart/updateQuantity') }}',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function(response) {
                            console.log(response.success, response.data);
                        },
                        error: function(error) {
                            console.log(error.responseJSON);
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                }
                // Cập nhật tổng tiền
                function updateTotalPrice() {
                    var total = 0;
                    var totalPriceElements = document.querySelectorAll('.total-price');
                    totalPriceElements.forEach(function(element) {
                        total += parseFloat(element.textContent.split('.').join(''));
                    });
                    document.getElementById('total').textContent = total.toLocaleString('it-IT');
                }

            });
        </script>
    @endpush
@endsection
