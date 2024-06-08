@extends('backend.master')
@section('title', 'Quản lý Danh mục')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">Danh sách danh mục</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-success" href="{{ url('/admin/categories/' . $extension . '/create') }}">Thêm
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
                            <option value="delete">Xóa danh mục</option>
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
                            <button class="uk-button" type="button" onclick="clean('{{ url('admin/categories/'.$extension) }}')">Làm
                                sạch</button>
                        </div>
                        <?php $limit_option = option('limit_categories'); ?>
                        <select class="numberPage"
                            onchange="javascript:jQuery(this).changeNumbePage('/admin/config/limited/' + this.value+'/limit_categories')">
                            @foreach (Config::get('app.limited') as $key_limit => $value_limit)
                                <option value="{{ $key_limit }}" {{ $key_limit == $limit_option ? 'selected' : '' }}>
                                    {{ $value_limit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="content">
                    @if (count($categories) > 0)
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                    <tr>
                                        <th><input class="select-all" type="checkbox" /></th>
                                        <th>Tên</th>
                                        <th>Lượt xem</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày sửa</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td><input type="checkbox" name="ids[]" value="{{ $category->id }}" /></td>
                                            <td>{{ tab_level($category) }}<a
                                                    href="{{ url('admin/categories/' . $extension . '/edit/' . $category->id) }}">{{ $category->name }}</a><br>
                                                <small>Slug: {{ $category->slug }}</small>
                                            </td>
                                            <td>0</td>
                                            <td>{{ date_format(date_create($category->created), 'd/m/Y') }}</td>
                                            <td>{{ date_format(date_create($category->modified), 'd/m/Y') }}</td>
                                            <td>
                                                @if ($category->stated == 0)
                                                    <a class="stated-off"
                                                        href="{{ url('/admin/categories/'.$extension.'/published/' . $category->id) }}">
                                                        <i class="uk-icon-toggle-off"></i>
                                                    </a>
                                                @else
                                                    <a class="stated-on"
                                                        href="{{ url('/admin/categories/'.$extension.'/published/' . $category->id) }}">
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
                            @include('backend.partials.pagination', ['paginator' => $categories])
                        </div>
                    @endif
                </div>
                <input type="hidden" name="task">
            </form>
        </div>
    </div>
@endsection
