@extends('frontend.user.index')
@section('option_content')
    <div class="uk-form uk-form-horizontal">
        <div class="uk-form-row">
            <h4>Hồ sơ của tôi</h4>
            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label uk-text-right" for="">Email Đăng Nhập </label>
            <div class="uk-form-controls">
                <input class="uk-width-3-5" type="text" name="email"
                    value="{{ Auth::check() ? Auth()->user()->email : '' }}">
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label uk-text-right" for="name_user">Tên </label>
            <div class="uk-form-controls">
                <input class="uk-width-3-5" type="text" name="name_user"
                    value="{{ Auth::check() ? Auth()->user()->name : '' }}">
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label uk-text-right" for="phone">Số điện thoại </label>
            <div class="uk-form-controls">
                <input class="uk-width-3-5" type="number" name="phone"
                    value="{{ Auth::check() ? Auth()->user()->phone : '' }}">
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label uk-text-right" for="gender">Giới tính </label>
            <div class="uk-form-controls uk-flex uk-flex-middle list-gender">
                <input type="radio" name="gender" value="1">Nam
                <input type="radio" name="gender" value="2">Nữ
                <input type="radio" name="gender" value="0">Khác
            </div>
        </div>
        {{-- <div class="uk-form-row">
            <label class="uk-form-label uk-text-right" for="">Ngày sinh</label>
            <div class="uk-form-controls uk-flex uk-flex-middle list-gender">

            </div>
        </div> --}}
    </div>
@endsection
