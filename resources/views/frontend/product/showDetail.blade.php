@extends('welcome')
@section('content')
    <div class="home-product">
        <div class="container">
            <div class="uk-grid">
                <div class="uk-width-1-1 uk-width-medium-4-10">
                    <div class="image-detail">
                        @foreach (json_decode($product->product_images) as $image)
                            <div>
                                <img style="width:100%" src="{{ asset('uploads/products/images/' . $image) }}" alt="Not found">
                            </div>
                        @endforeach
                    </div>
                    <div class="list-image-detail">
                        @foreach (json_decode($product->product_images) as $image)
                            <div>
                                <img src="{{ asset('uploads/products/images/' . $image) }}" alt="Not found">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="uk-width-1-1 uk-width-medium-6-10">
                    <div class="product-name">
                        <h2>{{ $product->name }}</h2>
                    </div>
                    <div class="product-price">
                        <span>{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                        <del>{{ number_format($product->product_price, 0, ',', '.') }}đ</del>
                    </div>
                    <div class="product-intro">
                        <p>{{ $product->introtext }}</p>
                    </div>
                    <div class="option option-color">
                        <div class="text-upcase">Chọn màu sắc: </div>
                        <div>
                            <ul>
                                @foreach (json_decode($product->product_colors) as $color)
                                    <li><button type="button" class="uk-button color button-choose-color">{{ $color }}</button></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="option option-size">
                        <div class="text-upcase">Chọn size: </div>
                        <div>
                            <ul>
                                @foreach (json_decode($product->product_sizes) as $size)
                                    <li><button type="button" class="uk-button size button-choose">{{ $size }}</button></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="option option-quantity">
                        <div class="text-upcase">Số lượng: </div>
                        <div class="change-quantity">
                            <button type="button" class="uk-button" id="decrease-quantity">-</button>
                            <input type="number" id="quantityProduct" value="1">
                            <button type="button" class="uk-button" id="increase-quantity">+</button><br>
                            <div style="padding-top: 10px"><span>Còn hàng</span></div>
                        </div>
                    </div>
                    <form id="checkout" action="{{ url('/cart/addToCart/' . $product->id) }}" method="POST">
                        @csrf
                        <div class="option-button-list">
                            <div class="button-addtocart">
                                <button class="uk-button">Thêm vào giỏ hàng</button>
                            </div>
                            <div class="button-buy">
                                <button class="uk-button uk-button-danger" id="buyNow">Mua ngay</button>
                            </div>
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="color" id="color" value="{{ json_decode($product->product_colors)[0] }}">
                            <input type="hidden" name="size" id="size" value="{{ json_decode($product->product_sizes)[0] }}">
                            <input type="hidden" name="quantity" id="quantityHidden" value="1">
                        </div>
                    </form>
                </div>
            </div>
            <div class="uk-grid product-description">
                <div class="title-description">
                    <span>CHI TIẾT SẢN PHẨM</span>
                </div>
                <div class="text-description">
                    @php
                        echo html_entity_decode($product->description);
                    @endphp
                </div>
            </div>
            <div class="product-similar">
                <h2>Sản phẩm tương tự</h2>
                @php
                    $listProduct = App\Models\Product::where('cate_id', $product->cate_id)
                        ->take(4)
                        ->get();
                    // dd($listProduct);
                @endphp
                <ul class="list-product-four">
                    @foreach ($listProduct as $item)
                        @include('frontend.partials.itemProduct', ['product' => $item])
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const inputQuantity = document.getElementById('quantityProduct');
            const quantityHidden = document.getElementById('quantityHidden');
            const increaseQuantity = document.getElementById('increase-quantity');
            const decreaseQuantity = document.getElementById('decrease-quantity');
            const buyNowBtn = document.getElementById('buyNow');
            var colorButtons = document.querySelectorAll('.color');
            var sizeButtons = document.querySelectorAll('.size');
            colorButtons.forEach(color => {
                color.addEventListener('click', function() {
                    $('.color').removeClass('button-choose-active');
                    var colorInput = document.getElementById('color');
                    colorInput.value = getTextButton(this);
                    this.classList.add('button-choose-active');
                })
            });
            sizeButtons.forEach(size => {
                size.addEventListener('click', function() {
                    $('.size').removeClass('button-choose-active');
                    var sizeInput = document.getElementById('size');
                    sizeInput.value = getTextButton(this);
                    this.classList.add('button-choose-active');
                })
            });

            function getTextButton(button) {
                return button.textContent;
            }

            increaseQuantity.addEventListener('click', function() {
                if (inputQuantity.value != 100) {
                    inputQuantity.value++;
                    quantityHidden.value++;
                }

            });
            decreaseQuantity.addEventListener('click', function() {
                if (inputQuantity.value != 1) {
                    inputQuantity.value--;
                    quantityHidden.value--;
                }

            });
            buyNowBtn.addEventListener('click',function(){
                const checkoutForm = document.getElementById('checkout');
                checkoutForm.action = "{{ url('/cart/addToCheckout') }}";
            })
            inputQuantity.addEventListener('input', function() {
                var value = parseInt(this.value);
                // console.log(value)

                quantityHidden.value = value;
                if (value < 1) {
                    this.value = 1;
                    quantityHidden.value = 1;
                } else if (value > 100) {
                    this.value = 100;
                    quantityHidden.value = 100;
                }

            });
        </script>
    @endpush
@endsection
