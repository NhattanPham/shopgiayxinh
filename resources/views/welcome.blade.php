<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xưởng Giày Dép</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/slick/slick.css') }}" />
    <link href="{{ asset('backend/assets/uikit/css/uikit.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/uikit.almost-flat.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/uikit/css/components/notify.almost-flat.min.css') }}">
    <link href="{{ asset('backend/assets/home.css') }}" rel="stylesheet">
</head>

<body>
    @include('frontend.partials.header')
    <main class="main-content">
        @yield('content')

        <div class="home-product"></div>
        <div class="home-product"></div>
        <div class="home-blog"></div>
        <div class="home-process"></div>
    </main>
    @include('frontend.partials.footer')
    <script src="{{ asset('backend/assets/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/uikit/js/uikit.min.js') }}"></script>
    <script src="{{ asset('backend/assets/slick/slick.min.js') }}"></script>
    <script src="{{ asset('backend/assets/uikit/js/components/notify.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('backend/assets/home.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.sliders').slick({
                dots: false,
                arrows: false,
                infinite: true,
                speed: 500,
                fade: true,
                autoplay: true,
                autoplaySpeed: 2000,
                cssEase: 'linear'
            });

            $('.slider-home').slick({
                dots: false,
                infinite: true,
                speed: 1000,
                fade: true,
                autoplay: true,
                autoplaySpeed: 2500,
                cssEase: 'linear'
            });
            $('.home-best-slick').slick({
                dots: false,
                infinite: true,
                speed: 300,
                autoplay: true,
                autoplaySpeed: 2000,
                centerPadding: '30px',
                slidesToShow: 5,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.slick-blog-home').slick({
                infinite: true,
                lazyLoad: 'ondemand',
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.logo-trademark-footer').slick({
                dots: false,
                infinite: true,
                speed: 300,
                autoplay: true,
                autoplaySpeed: 2000,
                centerPadding: '30px',
                slidesToShow: 8,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            $('.image-detail').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.list-image-detail'
            });
            $('.list-image-detail').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                arrows: true,
                asNavFor: '.image-detail',
                // dots: true,
                centerMode: true,
                focusOnSelect: true
            });
        });
    </script>
</body>

</html>
