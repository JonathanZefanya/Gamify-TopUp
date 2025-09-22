<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="{{ getFile($basicControl->favicon_driver, $basicControl->favicon) }}" rel="icon">
    <title>@lang(basicControl()->site_title) | @if (isset($pageSeo['page_title']))
            @lang($pageSeo['page_title'])
        @else
            @yield('title')
        @endif
    </title>
    @include('seo')

    <link rel="stylesheet" href="{{ asset(template(true) . 'css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/bootstrap.min.css')}}">
    @stack('css-lib')
    @stack('style')
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/aos.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/intlTelInput.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/ion.rangeSlider.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/jquery-ui.structure.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/nice-select.css')}}">

    <link rel="stylesheet" href="{{ asset(template(true) . 'css/style.css')}}">



</head>

<body>
<div class="">
{{--    @include(template() . 'partials.preloader')--}}
    @include(template() . 'partials.nav')

    @yield('content')
    @include(template().'sections.footer')
</div>

<script src="{{ asset(template(true) . '/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
@include(template() . 'partials.script')
@stack('extra_scripts')

@yield('scripts')
@include(template() . 'partials.flash-message')
@include('plugins')
@include(template().'partials.cookie')

</body>

</html>
