@extends('backend.master')
@section('title', 'Quản lý sản phẩm')
@section('content')
<div class="box-container">
    <header class="page-header">
        <h1 class="title-header">Danh sách sản phẩm</h1>
        <ul class="button-header">
            <li><a class="uk-button uk-button-success" href="{{ url('/admin/products/create') }}">Thêm
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
                        <option value="delete">Xóa sản phẩm</option>
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
                        <button class="uk-button" type="button" onclick="clean('{{ url('admin/products') }}')">Làm
                            sạch</button>
                    </div>
                    <?php $limit_option = option('limit_products'); ?>
                    <select class="numberPage"
                        onchange="javascript:jQuery(this).changeNumbePage('/admin/config/limited/' + this.value+'/limit_products')">
                        @foreach (Config::get('app.limited') as $key_limit => $value_limit)
                            <option value="{{ $key_limit }}" {{ $key_limit == $limit_option ? 'selected' : '' }}>
                                {{ $value_limit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="content">
                @if (count($products) > 0)
                <div class="uk-overflow-container">
                    <table class="uk-table">
                        <thead>
                            <tr>
                                <th><input class="select-all" type="checkbox" /></th>
                                <th>Hình đại diện</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td class="uk-text-middle"><input type="checkbox" name="ids[]" value="{{ $item->id }}" /></td>
                                    <td>
                                        <img style="width:80px; height:80px" src="{{ url($item->thumbnail) }}" alt="Not found">
                                    </td>
                                    <td class="uk-text-middle">
                                        <a href="{{ url('admin/products/edit/' . $item->id) }}">{{ $item->name }}</a>
                                    </td>
                                    <td class="uk-text-middle">{{ $item->product_price }}</td>
                                    <td class="uk-text-middle">{{ $item->sale_price }}</td>
                                    <td class="uk-text-middle">
                                        @if ($item->stated == 0)
                                            <a class="stated-off"
                                                >
                                                <i class="uk-icon-toggle-off"></i>
                                            </a>
                                        @else
                                            <a class="stated-on"
                                               >
                                                <i class="uk-icon-toggle-on"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    @include('backend.partials.pagination', ['paginator' => $products])
                </div>
                @endif
            </div>
            <input type="hidden" name="task">
        </form>
    </div>
</div>
@endsection