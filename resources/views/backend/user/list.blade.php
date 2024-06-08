@extends('backend.master')
@section('title','Quản lý Thành viên')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">Danh sách thành viên</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-success" href="{{ url('/admin/users/create') }}">Thêm mới</a></li>
            </ul>
        </header>
        <div class="box-content">
            <form action="" class="uk-form" name="adminList" method="GET">
                @include('backend.partials.message')
                <div class="toolbar">
                    <div class="action-toolbar">
                        <select name="action">
                            <option value="">Chọn hành động</option>
                            <option value="activated">Kích hoạt</option>
                            <option value="blocked">Khóa tài khoản</option>
                            <option value="unlocked">Mở khóa</option>
                            <option value="delete">Xóa thành viên</option>
                        </select>
                        <button class="uk-button" type="button" onclick="javascript:jQuery(this).submitList('changeAction')">Áp dụng</button>
                    </div>
                    <div class="filter-toolbar">
                        <div class="search-toolbar">
                            <input type="search" name="search" value="{{ request()->input('search') ? request()->input('search') : ''}}" placeholder="Tìm kiếm..." />
                            <button class="uk-button" type="button" onclick="javascript:jQuery(this).submitList('search')"><i class="uk-icon-search"></i></button>
                            <select name="user_group" onchange="javascript:jQuery(this).submitList('user_group')">
                                <option value="">Chọn nhóm thành viên</option>
                                @foreach (Config::get('auth.group_users') as $group_key => $group_value)
                                <option value="{{ $group_key }}" {{ (request()->input('user_group') == $group_key) ? 'selected' : ''}} >{{ $group_value }}</option>
                                @endforeach
                            </select>
                            <button class="uk-button" type="button" onclick="clean('{{ url('admin/users')}}')">Làm sạch</button>
                        </div>
                        <?php $limit_option = option('limit_users'); ?>
                        <select class="numberPage" onchange="javascript:jQuery(this).changeNumbePage('/admin/config/limited/' + this.value+'/limit_users')">
                            @foreach (Config::get('app.limited') as $key_limit => $value_limit)
                            <option value="{{ $key_limit }}" {{ ($key_limit == $limit_option) ? 'selected' : ''; }}>{{ $value_limit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="content">
                    @if(count($users) > 0)
                    <div class="uk-overflow-container">
                        <table class="uk-table">
                            <thead>
                                <tr>
                                    <th><input class="select-all" type="checkbox" /></th>
                                    <th>Họ tên</th>
                                    <th>Điện thoại</th>
                                    <th>Email</th>
                                    <th>Nhóm</th>
                                    <th>Kích hoạt</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="{{ $user->id }}" /></td>
                                    <td><a href="{{ url('/admin/users/edit/' . $user->id) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ group_user($user->group) }}</td>
                                    <td>{{ ($user->activated == 'Y') ? 'Có' : 'Chưa' }}</td>
                                    <td>
                                        @if ($user->blocked == 'Y')
                                        <a class="stated-off" href="{{ url('/admin/users/blocked/' . $user->id) }}">
                                            <i class="uk-icon-toggle-off"></i>
                                        </a>
                                        @else
                                        <a class="stated-on" href="{{ url('/admin/users/blocked/' . $user->id) }}">
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
                        @include('backend.partials.pagination', ['paginator' => $users])
                    </div>
                    @endif
                </div>
                <input type="hidden" name="task">
            </form>
        </div>
    </div>
@endsection