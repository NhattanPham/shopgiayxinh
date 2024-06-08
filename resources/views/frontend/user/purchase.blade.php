@extends('frontend.user.index')
@section('option_content')
    <div class="list-order">
        @foreach ($orders as $order)
            <div class="order-item">
                <div class="uk-flex uk-flex-space-between">
                    <div>Ngày đặt hàng: {{ $order->created}}</div>
                    <div class="uk-text-right">
                        <span class="uk-text-success"><i class="uk-icon-plane"></i>
                            {{ Config::get('app.order_stated')[$order->stated] }}</span> &emsp;
                        <a href="">LIÊN HỆ NGƯỜI BÁN</a>
                    </div>
                </div>
                <hr>
                @php
                    $order_item = $order->getOrderItem($order->id);
                    $total_price = 0;
                @endphp
                @foreach ($order_item as $item)
                    <div class="uk-flex uk-flex-space-between uk-flex-middle">
                        @php
                            $image = App\Models\Product::select('thumbnail')
                                ->where('id', $item->product_id)
                                ->first();
                            $total_price += $item->product_qty * $item->product_price;
                            // dd($thumbnail->thumbnail);
                        @endphp
                        <div class="uk-flex">
                            <div class="product-image">
                                <img style="width:80px; height:80px" src="{{ asset($image->thumbnail) }}" alt="Not Found">
                            </div>
                            <div>
                                {{ $item->product_name . ' - ' . $item->product_color . ' - ' . $item->product_size }} <br>
                                {{ ' x ' . $item->product_qty }}
                            </div>
                        </div>
                        <div>
                            <span class="uk-text-danger">{{ $item->product_qty * $item->product_price }}</span>
                        </div>
                    </div>
                @endforeach
                <hr>
                <div class="uk-text-right">Thành tiền: <span class="uk-text-danger">{{ $total_price }}</span></div>
                
            </div>
        @endforeach
    </div>
@endsection
