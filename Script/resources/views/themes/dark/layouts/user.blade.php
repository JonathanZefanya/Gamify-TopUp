<!DOCTYPE html>
<html lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif />
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <link href="{{ getFile($basicControl->favicon_driver, $basicControl->favicon) }}" rel="icon">
        <title>@yield('title') | {{basicControl()->site_title}}</title>
        @include('themes.dark.partials.user.'.getDash().'.style')
    </head>
    <body onload="preloaderFunction()" class="">
        <div class="dashboard-wrapper">
            @include(template() . 'partials.preloader')
            <div class="dashboard-container">
                @if(getDash() == 'nightfall')
                    @include('themes.dark.partials.user.'.getDash().'.topbar')
                    @include('themes.dark.partials.user.'.getDash().'.bottomNav')
                    @include('themes.dark.partials.user.'.getDash().'.sidebar')
                    <main id="main" class="main">
                        <div class="main-wrapper">
                            @section('content')
                            @show
                        </div>
                    </main>
                    @include('themes.dark.partials.user.customSidebar')
                @else
                    @include('themes.dark.partials.user.'.getDash().'.topbar')
                    @yield('content')
                    @include('themes.dark.partials.user.customSidebar')
                @endif
            </div>
        </div>

        @include('plugins')
        @include('themes.dark.partials.user.'.getDash().'.script')
        @include('themes.dark.partials.user.'.getDash().'.flash-message')

        @include(template().'partials.cookie')
    </body>
</html>

