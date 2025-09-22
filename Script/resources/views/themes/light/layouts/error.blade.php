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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include(template() . 'partials.style')

</head>

<body>
<div class="">
{{--    @include(template() . 'partials.preloader')--}}

    @yield('content')

</div>


@include(template() . 'partials.script')

<script>

</script>
</body>

</html>
