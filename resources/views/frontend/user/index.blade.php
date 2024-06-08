@extends('welcome')
@section('content')
    <div class="container profile">
        <div class="uk-grid">
            <div class="uk-width-1-4">
                <div class="user-option">
                    <div class="avatar">
                    </div>
                    <div class="profile-link">
                        <a href="/profile" class="uk-flex uk-flex-middle">
                            <i class="uk-icon-user"></i>
                            Tài khoản của tôi
                        </a>
                    </div>
                    <div class="purchase-link ">
                        <a href="/purchase">
                            <i class="uk-icon-clipboard"></i> Đơn mua
                        </a>
                    </div>
                </div>
            </div>
            <div class="uk-width-3-4 info">
                @yield('option_content')
                
            </div>
        </div>
    </div>
@endsection
