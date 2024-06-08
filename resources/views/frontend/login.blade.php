@extends('welcome')
@section('content')
    <div class="home-product">
        <div class="container">
            <div class="uk-grid login-page uk-flex-center">
                <div class="uk-width-1-2 login">
                    <form class="uk-form uk-form-stacked" action="{{ url('login') }}" method="POST">
                        @csrf
                        <div class="uk-form-row uk-text-center">
                            <h2>ĐĂNG NHẬP</h2>
                        </div>
                        @if (session('login-fail'))
                            <div class="uk-alert uk-alert-danger">
                                <p>{{ session('login-fail') }}</p>
                            </div>
                        @endif
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="email_login">Email</label>
                            @error('email_login')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="text" name="email_login" id="email_login">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="password_login">Mật khẩu</label>
                            @error('password_login')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="password" name="password_login" id="password_login">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <button class="uk-button button-color-page">Đăng nhập</button> <a href="">Quên mật
                                khẩu</a>
                        </div>
                        <div class=" uk-form-row uk-flex uk-flex-middle">
                            <div class="uk-width-1-1">
                                <hr>
                            </div>
                            <div>HOẶC</div>
                            <div class="uk-width-1-1">
                                <hr>
                            </div>
                        </div>
                        <div class="uk-form-row uk-flex uk-flex-space-around">
                            <div class="uk-flex uk-flex-middle uk-flex-center button-login-type uk-button login-facebook">
                                <i></i> Facebook
                            </div>
                            <div class="uk-flex uk-flex-middle uk-flex-center button-login-type uk-button login-google">
                                <i></i> Google
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <p>Nếu Quý khách có vấn đề gì thắc mắc hoặc cần hỗ trợ gì thêm có thể liên hệ:</p>
                            <a href="">Hotline: {{ option('phone') }}</a><br>
                            <a href="">Hoặc Inbox Facebook</a>
                        </div>
                    </form>
                </div>
                <div class="uk-width-1-2 register">
                    <form class="uk-form uk-form-stacked" action="{{ url('register') }}" method="POST">
                        @csrf
                        <div class="uk-form-row uk-text-center">
                            <h2>ĐĂNG KÝ</h2>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="email">Email</label>
                            @error('email')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="email" name="email" id="email">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="name">Tên</label>
                            @error('name')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="text" name="name" id="name">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="phone">Số điện thoại</label>
                            @error('phone')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="number" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="password">Mật khẩu</label>
                            @error('password')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="password" name="password" id="password">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="password-confirm">Nhập lại mật khẩu</label>
                            @error('password-confirm')
                                <div class="uk-text-danger">{{ $message }}</div>
                            @enderror
                            <div class="uk-form-controls">
                                <input type="password" name="password-confirm" id="password-confirm">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <button class="uk-button button-color-page">Đăng ký</button>
                        </div>
                        <div class="uk-form-row">
                            <p>Thông tin cá nhân của bạn sẽ được dùng để điền vào hóa đơn, giúp bạn thanh toán nhanh chóng
                                và dễ dàng</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('register-success'))
        @push('scripts')
            <script>
                UIkit.notify("{{ session('register-success')}}", {
                    status: 'success'
                });
            </script>
        @endpush
    @endif
@endsection
