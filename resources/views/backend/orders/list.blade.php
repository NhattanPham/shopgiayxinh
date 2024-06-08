@extends('backend.master')
@section('title', 'Quản đơn hàng')
@section('content')
<div class="box-container">
    <header class="page-header">
        <h1 class="title-header">Danh sách đơn hàng</h1>
        <ul class="button-header">
            <li><a class="uk-button uk-button-success" href="{{ url('/admin/orders/create') }}">Thêm
                    mới</a></li>
        </ul>
    </header>
    <div class="box-content">
        <form action="" class="uk-form" name="adminList" method="GET">
            @include('backend.partials.message')
            <div class="toolbar">
                <div class="action-toolbar">
                    <select name="action">
                        <option value="">Chọn hành động</option>
                        <option value="published">Xuất bản</option>
                        <option value="unpublished">Không xuất bản</option>
                        <option value="delete">Xóa đơn hàng</option>
                    </select>
                    <button class="uk-button" type="button"
                        onclick="javascript:jQuery(this).submitList('changeAction')">Áp dụng</button>
                </div>
                <div class="filter-toolbar">
                    <div class="search-toolbar">
                        <input type="search" name="search"
                            value="{{ request()->input('search') ? request()->input('search') : '' }}"
                            placeholder="Tìm kiếm..." />
                        <button class="uk-button" type="button"
                            onclick="javascript:jQuery(this).submitList('search')"><i
                                class="uk-icon-search"></i></button>
                        <button class="uk-button" type="button" onclick="clean('{{ url('admin/orders') }}')">Làm
                            sạch</button>
                    </div>
                    <?php $limit_option = option('limit_orders'); ?>
                    <select class="numberPage"
                        onchange="javascript:jQuery(this).changeNumbePage('/admin/config/limited/' + this.value+'/limit_orders')">
                        @foreach (Config::get('app.limited') as $key_limit => $value_limit)
                            <option value="{{ $key_limit }}" {{ $key_limit == $limit_option ? 'selected' : '' }}>
                                {{ $value_limit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="content">
                @if (count($orders) >0)
                <table class="uk-table">
                    <thead>
                        <tr>
                            <th><input class="select-all" type="checkbox" /></th>
                            <th>Mã đơn hàng</th>
                            <th>Người mua</th>
                            <th>Ngày tạo</th>
                            <th>Ngày sửa</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $order->id }}" /></td>
                                <td>
                                    <a href="{{ url('admin/orders/edit/' . $order->id) }}">{{ $order->code_order }}</a>
                                </td>
                                <td>{{ $order->buyer }}</td>
                                <td>{{ date_format(date_create($order->created), 'd/m/Y') }}</td>
                                <td>{{ date_format(date_create($order->created), 'd/m/Y') }}</td>
                                <td>
                                    @if ($order->stated == 0)
                                        <a class="stated-off"
                                            href="{{ url('/admin/order/published/' . $order->id) }}">
                                            <i class="uk-icon-toggle-off"></i>
                                        </a>
                                    @else
                                        <a class="stated-on"
                                            href="{{ url('/admin/order/published/' . $order->id) }}">
                                            <i class="uk-icon-toggle-on"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <input type="hidden" name="task">
        </form>
    </div>
</div>
@endsection