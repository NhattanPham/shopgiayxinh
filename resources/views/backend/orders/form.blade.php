@extends('backend.master')

@section('title', isset($order) ? 'Chỉnh sửa đơn hàng' : 'Thêm đơn hàng')

@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($order) ? 'Sửa đơn hàng' : 'Thêm đơn hàng' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/orders') }}">Trở về</a>
                </li>
            </ul>
        </header>
        <div class="box-content">
            @include('backend.partials.message')
            <form class="uk-form uk-form-stacked" action="{{ url('admin/orders') }}" method="POST" name="adminForm"
                enctype="multipart/form-data">
                @csrf
                <div class="content">
                    <div class="uk-grid">
                        <h4>Chi tiết đơn hàng</h4>
                        <div class="uk-width-1-1">
                            @isset($order)
                                <p><strong>Mã đơn hàng:</strong> #{{ isset($order) ? $order->code_order : '' }}</p>
                                <p><strong>Ngày tạo: </strong> {{ isset($order) ? $order->created : '' }}</p>
                            @endisset

                            <p><strong>Phương thức thanh toán: </strong>
                                @php
                                    $payments = Config::get('app.order_payment_method');
                                @endphp
                                <select name="payment" id="">
                                    @foreach ($payments as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ isset($order) ? ($order->payment == $key ? 'selected' : '') : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p><strong>Trạng thái: </strong>
                                @php
                                    $stated = Config::get('app.order_stated');
                                @endphp
                                <select name="stated" id="">
                                    @foreach ($stated as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ isset($order) ? ($order->stated == $key ? 'selected' : '') : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="notes">Ghi chú</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" name="notes" id="" rows="3">{{ isset($order) ? $order->notes : '' }} </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <h4>Thông tin khách hàng</h4>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-2">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="buyer">Người mua</label>
                                <div class="uk-form-controls">
                                    <input type="text" class="uk-width-1-1" name="buyer" id="buyer"
                                        value="{{ isset($order) ? $order->buyer : '' }}">
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="phone">Số điện thoại</label>
                                <div class="uk-form-controls">
                                    <input type="number" class="uk-width-1-1" name="phone" id="phone"
                                        value="{{ isset($order) ? $order->phone : '' }}">
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="phone">Email</label>
                                <div class="uk-form-controls">
                                    <input type="email" class="uk-width-1-1" name="email" id="email"
                                        value="{{ isset($order) ? $order->email : '' }}">
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="customer_request">Yêu cầu của khách hàng</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" name="customer_request" id="" rows="3">{{ isset($order) ? $order->request : '' }} </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2">
                            {{-- <h4>Thông tin vận chuyển</h4> --}}
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="province">Tỉnh/Thành phố</label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1" name="province" id="province">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        @isset($province)
                                            @foreach ($province as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $order->province_id ? 'selected' : '' }}>
                                                    {{ $item->_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="district">Quận/Huyện</label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1" name="district" id="district">
                                        <option value="">Chọn quận/huyện</option>
                                        @isset($district)
                                            @foreach ($district as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $order->district_id ? 'selected' : '' }}>
                                                    {{ $item->_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="ward">Phường/Xã</label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1" name="ward" id="ward">
                                        <option value="">Chọn phường/xã</option>
                                        @isset($ward)
                                            @foreach ($ward as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $order->ward_id ? 'selected' : '' }}>
                                                    {{ $item->_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="ward">Địa chỉ cụ thể</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" name="address" id="address" rows="3">{{ isset($order) ? $order->address : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-flex uk-panel">
                                <h2>Danh sách sản phẩm</h2>
                                <button type="button" class="add-product uk-button uk-button-primary">Thêm sản
                                    phẩm</button>
                            </div>
                            <table style="{{ count($listProduct) > 0 ? '' : 'display:none;' }}"
                                class="uk-table list-product-order">
                                <thead>
                                    <th>
                                        Hình sản phẩm
                                    </th>
                                    <th>
                                        Tên
                                    </th>
                                    <th>
                                        Giá
                                    </th>
                                    <th>
                                        Số lượng
                                    </th>
                                    <th>
                                        Tổng giá
                                    </th>
                                    <th>
                                        Màu
                                    </th>
                                    <th>
                                        Size
                                    </th>
                                    <th>
                                        Hành động
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($listProduct as $item)
                                        @php
                                            $product = App\Models\Product::find($item->product_id);
                                        @endphp
                                        <tr class="data-order-item" {{ isset($item->id) ? 'data-id=' . $item->id : '' }}
                                            data-product_id="{{ $product->id }}"
                                            data-product_name="{{ $product->name }}"
                                            data-product_qty="{{ $item->product_qty }}"
                                            data-product_price="{{ $product->sale_price }}"
                                            data-product_color="{{ $item->product_color }}"
                                            data-product_size="{{ $item->product_size }}">
                                            <td>
                                                <img style="width:80px; height:80px"
                                                    src="{{ asset($product->thumbnail) }}" alt="Not found">
                                            </td>
                                            <td>
                                                {{ $product->name }}
                                            </td>
                                            <td>
                                                {{ $product->sale_price }}
                                            </td>
                                            <td>
                                                <div class="item-detail">
                                                    {{ $item->product_qty }}
                                                </div>
                                                <div class="item-edit">
                                                    <button type="button" class="uk-button quantity-decrese">-</button>
                                                    <input type="number" class="input-quantity"
                                                        value="{{ $item->product_qty }}">
                                                    <button type="button" class="uk-button quantity-increse">+</button>
                                                </div>

                                            </td>
                                            <td class="total-price">
                                                {{ $product->sale_price * $item->product_qty }}
                                            </td>
                                            <td>
                                                <div class="item-detail">{{ $item->product_color }}</div>
                                                <div class="item-edit">
                                                    <select name="" class="order_item_color">
                                                        @foreach (json_decode($product->product_colors) as $item_color)
                                                            <option
                                                                {{ $item_color == $item->product_color ? 'selected' : '' }}>
                                                                {{ $item_color }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-detail">{{ $item->product_size }}</div>
                                                <div class="item-edit">
                                                    <select name="" class="order_item_size">
                                                        @foreach (json_decode($product->product_sizes) as $item_size)
                                                            <option
                                                                {{ $item_size == $item->product_size ? 'selected' : '' }}>
                                                                {{ $item_size }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="uk-button delete-product">&#x2715;</button>
                                                <button type="button" class="uk-button edit-product"><i
                                                        class="uk-icon-edit"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="no-product-text">
                                        <h4>Chưa có sản phẩm nào được thêm</h4>
                                    </div>
                                </tbody>
                            </table>
                            <div style="{{ count($listProduct) > 0 ? '' : 'display:none;' }}"
                                class="total-container uk-text-right">
                                <p class="total-all-product"><strong>Tổng tiền hàng : </strong><span></span></p>
                                <p class="ship"><strong>Phí vận chuyển : </strong><span>30000</span></p>
                                <p class="total-pay"><strong>Tổng thanh toán : </strong><span></span></p>
                            </div>

                        </div>
                        <br>

                    </div>
                </div>


        </div>
        <input type="hidden" name="list_order_item" class="list-order-item" value="">
        <input type="hidden" name="order_id" value="{{ isset($order) ? $order->id : 0 }}">
        </form>
        <div class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Thêm sản phẩm</h2>
                <div class="uk-grid">
                    <div class="page-search uk-form">
                        <input class="" type="search" name="search" id="search"
                            placeholder="Tìm kiếm sản phẩm..." value="">
                        <button id="btnSearchProduct" class="uk-button">
                            <i class="uk-icon-search"></i>
                        </button>
                    </div>
                </div>
                <table class="uk-table uk-table-hover uk-form product-table ">
                    <thead>
                        <tr>
                            <th><input class="select-all" type="checkbox" id="select-all-product"></th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Màu</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <button class="uk-button" type="button" id="prevPage">&#11164;</button>
                <span id="product-pagination">
                </span>
                <button class="uk-button" type="button" id="nextPage">&#11166;</button>
                <div>
                    <button class="uk-button uk-button-primary" id="addProduct">Thêm</button>
                </div>
            </div>

        </div>
    </div>
    </div>
    @push('scripts')
        <script src="{{ asset('backend/assets/order.js') }}"></script>
    @endpush

@endsection
