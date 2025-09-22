<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ getFile($basicControl->favicon_driver, $basicControl->favicon) }}" rel="icon">
    <title>@lang(basicControl()->site_title) | @if (isset($pageSeo['page_title']))
            @lang($pageSeo['page_title'])
        @else
            @yield('title')
        @endif
    </title>
    @include('seo')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include(template() . 'partials.style')

</head>

<body>
<div class="">
    @include(template() . 'partials.preloader')
    @include(template() . 'partials.nav')

    @yield('content')

    @include(template() . 'sections.footer')
    @include(template() . 'partials.script')
    @stack('extra_scripts')
    @yield('scripts')
    @include(template() . 'partials.flash-message')
    @include('plugins')

    @include(template().'partials.cookie')


</body>

</html>
