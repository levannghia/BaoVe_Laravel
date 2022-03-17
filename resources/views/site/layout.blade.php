@php
use App\Models\Config;
$footer = DB::table('pages')
    ->where('slug', 'footer')
    ->first();
$favicon = DB::table('photos')
    ->where('type', 'favicon')
    ->first();
$logo = DB::table('photos')
    ->where('type', 'logo')
    ->first();
$social_footer = DB::table('photos')
    ->where('status', 1)
    ->where('type', 'social-footer')
    ->get();
$settings = Config::all(['name', 'value'])
    ->keyBy('name')
    ->transform(function ($setting) {
        return $setting->value; // return only the value
    })
    ->toArray();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$mxh_top = DB::table('photos')
    ->where('status', 1)
    ->where('type', 'social-top')
    ->orderBy('stt', 'ASC')
    ->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="@yield('SEO_keywords')" />
    <meta name="description" content="@yield('SEO_description')" />
    <meta name="theme-color" content="#1E88EC" />
    <meta name="robots" content="index,follow" />
    <link href="{{ asset('public/upload/images/photo/thumb/' . $favicon->photo) }}" rel="shortcut icon"
        type="image/x-icon" />
    <meta name="google-site-verification" content="Rtlj-iT3T9o_064yPWlrvfl93FnpLG1uR6oEZFMl_KI" />
    <meta name="geo.region" content="VN" />
    <meta name="geo.placename" content="" />
    <meta name="geo.position" content="{{ $settings['MAP_TOA_DO'] }}" />
    <meta name="ICBM" content="{{ $settings['MAP_TOA_DO'] }}" />
    <meta name='revisit-after' content='1 days' />
    <meta name="author" content="{{ $settings['TITLE'] }}" />
    <meta name="copyright" content="{{ $settings['TITLE'] }} - [{{ $settings['EMAIL'] }}]" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $settings['TITLE'] }}" />
    <meta property="og:title" content="@yield('SEO_title')" />
    <meta property="og:description" content="@yield('SEO_description')" />
    <meta property="og:url" content="{{ $url }}" />
    <meta property="og:image" content="@yield('PHOTO')" />
    <meta property="og:image:alt" content="@yield('SEO_title')" />
    <meta property="og:image:type" content="@yield('mimeType')" />
    <meta property="og:image:width" content="@yield('width')" />
    <meta property="og:image:height" content="@yield('height')" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{ $settings['EMAIL'] }}" />
    <meta name="twitter:creator" content="{{ $settings['TITLE'] }}" />
    <meta property="og:url" content="{{ $url }}" />
    <meta property="og:title" content="@yield('SEO_title')" />
    <meta property="og:description" content="@yield('SEO_description')" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0">
    <link rel="canonical" href="{{ $url }}" />
    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/v4-shims.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" href="{{ asset('public/site/css/default.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('public/site/css/nivo-slider.css') }}" type="text/css" media="screen" /> --}}
    <link rel="stylesheet" href="{{ asset('public/site/css/contact.css?v-' . time()) }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/style.css?v-' . time()) }}">
    {{-- <link rel="stylesheet" href="{{ asset('public/site/css/cart.css?v-' . time()) }}"> --}}
    <link rel="stylesheet" href="{{ asset('public/site/fonts/slick/slick.woff') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/trang.css?v-' . time()) }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>@yield('SEO_title')</title>
    {!! $settings['ANALYTICS'] !!}
    {!! $settings['WEB_MASTER_TOOL'] !!}
    {!! $settings['HEAD_JS'] !!}
</head>

<body>
    {{-- header --}}
    @include('site.inc.header')

    {{-- content --}}
    @yield('content')

    {{-- footer --}}
    @include('site.inc.footer')

    <!-- Scrollable modal -->

    <!-- Optional JavaScript -->
    @include('site.inc.script')
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script> --}}
    {{-- https://unpkg.com/sweetalert/dist/sweetalert.min.js --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v13.0&appId=590530215089180&autoLogAppEvents=1"
        nonce="6XAmrWOg"></script>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <script src="{{ asset('public/site/js/sweetalert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('public/site/js/owl.carousel.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-simplyscroll/2.1.1/jquery.simplyscroll.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-simplyscroll/2.1.1/jquery.simplyscroll.css" media="all"
        type="text/css">
    <script type="text/javascript">
        (function($) {
            $(function() { //on DOM ready
                $("#scroller").simplyScroll({
                    customClass: 'vert',
                    orientation: 'vertical',
                    auto: true,
                    manualMode: 'loop',
                    frameRate: 10,
                    speed: 0.5
                });
            });
        })(jQuery);


        $(window).load(function() {
            $('#slider').nivoSlider();
        });
    </script>
    @stack('script_site')
</body>

</html>
