<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/uikit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/uikit.almost-flat.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/components/nestable.almost-flat.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/components/sortable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/components/accordion.almost-flat.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/template.css') }}">
</head>
<body>
    <div class="sidebar">
		<div class="logo-brand">
			<i class="uk-icon-dot-circle-o"></i><span class="name-brand">Administrator</span>
		</div>
		@include('backend.partials.menu')
	</div>
	<section class="page-section">
		<nav class="navbar">
			<div class="left-navbar">
				<div class="toggle-sidebar">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</div>
				<h2 class="title-navbar">@yield('title')</h2>
			</div>
			<div class="right-navbar">
				<ul class="icon-notification">
					<li class="email-notification"><a href=""><i class="uk-icon-envelope"></i><span class="count-notification">20</span></a></li>
					<li class="bell-notification"><a href=""><i class="uk-icon-bell"></i><span class="count-notification">20</span></a></li>
					<li class="mess-notification"><a href=""><i class="uk-icon-commenting"></i><span class="count-notification">20</span></a></li>
				</ul>
				<div class="user-profile">
					<div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
						<div class="uk-icon-button">
							<i class="uk-icon-user"></i>
						</div>
						<div class="uk-dropdown">
							<ul class="uk-nav uk-nav-dropdown">
								<li><a href="">Thông tin tài khoản</a></li>
								<li><a href="">Đổi mật khẩu</a></li>
								<li><a href="{{ url('logout') }}">Đăng xuất</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<main class="main-content">
            @yield('content')
		</main>
	</section>
     {{-- Jquery --}}
     <script src="{{ asset('backend/assets/jquery.min.js') }}"></script>
     {{-- Uikit --}}
     <script src="{{ asset('backend/assets/uikit/js/uikit.min.js') }}"></script>
     {{-- Link nestable js --}}
     <script src="{{ asset('backend/assets/uikit/js/components/nestable.min.js') }}"></script>
      {{-- Link sortable js --}}
      <script src="{{ asset('backend/assets/uikit/js/components/sortable.min.js') }}"></script>
     {{-- Link accordion js --}}
     <script src="{{ asset('backend/assets/uikit/js/components/accordion.min.js') }}"></script>
     {{-- Link tinymce js --}}
     <script src="{{ asset('backend/assets/tinymce/tinymce.min.js') }}"></script>
	 @stack('scripts')
     <script src="{{ asset('backend/assets/action.js') }}"></script>
	</body>
</html>