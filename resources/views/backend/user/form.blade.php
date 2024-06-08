@extends('backend.master')
@section('title', isset($user) ? 'Sửa thành viên' : 'Thêm thành viên')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($user) ? 'Sửa thành viên' : 'Thêm thành viên' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)" onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)" onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/users') }}">Trở về</a></li>
            </ul>
        </header>
        <div class="box-content">
            <form class="uk-form uk-form-horizontal" action="{{ url('admin/users') }}" name="adminForm" method="POST">
                @include('backend.partials.message')
                <div class="content form-users">
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="group">Nhóm thành viên</label>
                        <div class="uk-form-controls">
                            <select name="group" id="group">
                                <option value="">- Chọn nhóm -</option>
                                @foreach (Config::get('auth.group_users') as $group_key => $group_value)
                                    <option value="{{ $group_key }}"
                                        {{ $group_key == (isset($user) ? $user->group : '') ? 'selected' : '' }}>
                                        {{ $group_value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="name">Họ tên</label>
                        <div class="uk-form-controls">
                            <input type="text" name="name" id="name"
                                value="{{ isset($user) ? $user->name : '' }}">
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="phone">Điện thoại</label>
                        <div class="uk-form-controls">
                            <input type="number" name="phone" id="phone"
                                value="{{ isset($user) ? $user->phone : '' }}">
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="email">Email</label>
                        <div class="uk-form-controls">
                            <input type="email" name="email" id="email"
                                value="{{ isset($user) ? $user->email : '' }}">
                        </div>
                    </div>
                    @if (isset($user))
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">Mật khẩu</label>
                            <div class="uk-form-controls">
                                <button type="button" class="uk-button" data-uk-toggle="{target:'.reset-password'}">Đặt lại
                                    mật
                                    khẩu</button>
                                <div class="reset-password uk-hidden">
                                    <div class="uk-form-row">
                                        <label for="password">Mật khẩu mới</label><br>
                                        <input type="password" name="password" id="password">
                                    </div>
                                    <div class="uk-form-row">
                                        <label for="password_confirmation">Nhập lại mật khẩu mới</label><br>
                                        <input type="password" name="password_confirmation" id="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="password">Mật khẩu</label>
                            <div class="uk-form-controls">
                                <input type="password" name="password" id="password">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="password_confirmation">Nhập lại mật khẩu</label>
                            <div class="uk-form-controls">
                                <input type="password" name="password_confirmation" id="password_confirmation">
                            </div>
                        </div>
                    @endif
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="blocked">Trạng thái</label>
                        <div class="uk-form-controls">
                            <select name="blocked" id="blocked">
                                <option value="Y" >Khóa</option>
                                <option value="N" {{ isset($user) ? ($user->blocked == 'N' ? 'selected' : ''): ''}}>Mở</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="activated">Kích hoạt</label>
                        <div class="uk-form-controls">
                            <span style="margin-right: 1rem">
                            <input type="radio" name="activated" value="Y" {{ isset($user) ? ($user->activated == 'Y' ? 'checked' : ''): ''}}> Đã kích hoạt</span>
                            <span>
                            <input type="radio" name="activated" value="N" {{ isset($user) ? ($user->activated == 'N' ? 'checked' : ''): ''}}> Chưa kích hoạt</span>
                        </div>
                    </div>
                </div>
                @csrf
                <input type="hidden" name="id" value="{{ isset($user) ? $user->id : 0}}">
                <input type="hidden" name="action">
            </form>
        </div>
    </div>
@endsection
