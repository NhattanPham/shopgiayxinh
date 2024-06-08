@php
    use App\Models\MenuItem;
    use App\Models\Menu;
    $menuHeader = Menu::where('name', 'like', 'header')->first();
    $menus = MenuItem::where('parent_id', 0)
        ->where('menu_id', $menuHeader->id)
        ->orderBy('ordering')
        ->get();
    // dd($menus);
@endphp

<header class="header">
    <div class="main-header">
        <div class="container">
            <div class="top-header">
                <div class="phone-header">
                    <i class="icon-phone-header"></i> 0909.57.80.85
                </div>
                <div class="menu-top">
                    <ul class="menu">
                        <li><a href="">Người mới</a></li>
                        <li><a href="">Hổ trợ</a></li>
                        <li><a href="">Đơn hàng</a></li>
                        {{-- <li><a href="">Đăng ký</a></li>
                        <li><a href="">Đăng nhập</a></li> --}}
                        @if (Auth::check())
                            <li>
                                <a href="{{ url('profile') }}">Xin chào, {{ Auth::user()->name }}</a>
                            </li>
                            <li>
                                <a href="{{ url('logout') }}">
                                    Đăng xuất
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ url('register') }}">Đăng ký</a>
                            </li>
                            <li>
                                <a href="{{ url('login') }}">Đăng nhập</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="wrapper-header">
                <div class="logo-header">
                    <a class="logo" href="{{ url('/') }}">XUONGGIAYDEP.VN</a>
                </div>
                <div class="search-header">
                    <form class="form-search">
                        <select name="" class="select-search">
                            <option>Chọn danh mục</option>
                            <option>Giày dép nam</option>
                            <option>Giày dép nữ</option>
                        </select>
                        <input class="input-search" type="search" placeholder="Nhập từ khóa cần tìm...">
                        <button class="button-search" type="button">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                </div>
                <div class="icon-header">
                    <ul class="list-icon-header">
                        <li class="notify-header"><a href=""><i class="icon-bell"></i></a></li>
                        <li class="wishlist-header"><a href="{{ url('wishlist') }}"><i class="icon-heart"></i></a></li>
                        <li class="cart-header">
                            <a class="button-cart-header" href="{{ url('cart') }}">
                                <i class="icon-cart"></i><span class="text-cart">Giỏ hàng</span>
                                <span 
                                    class="count-cart-header">{{ Cookie::get('cart-items') ? count(json_decode(Cookie::get('cart-items'))) : 0 }}</span>
                            </a>
                        </li>
                        <li><button class="uk-button show-drawer" 
                            data-uk-offcanvas="{target:'#drawer',mode:'slide'}">&#9776;</button></li>
                    </ul>
                </div>
                <div id="drawer" class="uk-offcanvas">
                    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
                        <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
                            @if (Auth::check())
                                <li class="uk-parent">
                                    <a href="#">Xin chào, {{ Auth::user()->name }}</a>
                                    <ul class="uk-nav-sub">
                                        <li>
                                            <a href="profile">Thông tin khách hàng</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('logout') }}">Đăng xuất</a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li><a href="/login">Đăng nhập/Đăng ký</a></li>
                            @endif
                            <li><a href="">Tìm kiếm</a></li>
                            @foreach ($menus as $menu)
                                @if ($menu->children->count() > 0)
                                    <li class="uk-parent">
                                        <a href="#">{{ $menu->name }}</a>
                                        <ul class="uk-nav-sub">
                                            <li>
                                                <a href="{{ $menu->url }}">Xem tất cả</a>
                                            </li>
                                            @foreach ($menu->children as $item)
                                                <li>
                                                    <a href="{{ $item->url }}">{{ $item->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $menu->url }}">{{ $menu->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="bar-nav">
        <div class="container">
            <div class="main-menu">
                <ul class="menu">
                    @foreach ($menus as $menu)
                        <li class="menu-item">
                            <a href="{{ url($menu->url) }}">{{ $menu->name }}</a>
                            @if ($menu->children->count() > 0)
                                <ul class="sub-menu">
                                    @foreach ($menu->children as $item)
                                        {{-- về nhà chỉnh sửa lại style --}}
                                        <li class="menu-item"><a href="{{ $item->url }}">{{ $item->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>
