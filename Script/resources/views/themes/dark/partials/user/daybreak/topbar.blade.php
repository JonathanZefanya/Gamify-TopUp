<header id="header" class="header">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="header-left">
                    @include('themes.dark.partials.user.'.getDash().'.nav')
                    <div class="search-bar dashSearch">
                        <form class="search-form d-flex align-items-center">
                            <input type="search" class="form-control global-search" id="search-input" name="query" placeholder="@lang('Search')"
                                   title="@lang('Enter search keyword')">
                            <span class="search-icon" title="Search"><i class="fa-regular fa-magnifying-glass"></i></span>
                            <div class="search-result d-none">
                                <div class="search-header">
                                    @lang('Result')
                                </div>
                                <div class="content searchItems" id="search-result"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
                <div class="header-nav">
                    <div class="logo-container d-lg-none">
                        <a href="{{ route('page', '/') }}" class="logo d-flex align-items-center">
                            <img src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="GAMOT">
                        </a>
                    </div>
                    <ul class="nav-icons">
                        <li class="nav-item">
                            <a id="toggle-btn" class="nav-link d-flex toggle-btn">
                                <i class="fa-light fa-moon" id="moon"></i>
                                <i class="fa-light fa-sun-bright" id="sun"></i>
                            </a>
                        </li>
                        @include(template().'partials.user.pushNotify')
                        <!-- Notification section end -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                               data-bs-toggle="dropdown">
                                <img src="{{ getFile(auth()->user()->image_driver, auth()->user()->image) }}" alt="{{ auth()->user()->username }}" class="rounded-circle">
                                <span class="d-none d-xl-block dropdown-toggle ps-2">{{ auth()->user()->firstname.' '.auth()->user()->lastname }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                <li
                                    class="dropdown-header d-flex justify-content-center align-items-center text-start">
                                    <div class="profile-thum">
                                        <img src="{{ getFile(auth()->user()->image_driver, auth()->user()->image) }}" alt="{{ auth()->user()->username }}">
                                    </div>
                                    <div class="profile-content">
                                        <h6>{{ auth()->user()->firstname.' '.auth()->user()->lastname }}</h6>
                                        <span>{{ '@'.auth()->user()->username }}</span>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center {{ menuActive(['user.profile']) }}"
                                       href="{{ route('user.profile') }}">
                                        <i class="fa-light fa-user"></i>
                                        <span>@lang('My Profile')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center {{ menuActive('user.updatePassword') }}"
                                       href="{{ route('user.updatePassword') }}">
                                        <i class="fa-sharp fa-light fa-shield"></i>
                                        <span>@lang('Password Setting')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center {{ menuActive(['user.kyc.settings']) }}" href="{{ route('user.kyc.settings') }}">
                                        <i class="fa-sharp fa-light fa-lock"></i>
                                        <span>@lang('Identity Verification')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center {{ menuActive(['user.twostep.security']) }}"
                                       href="{{ route('user.twostep.security') }}">
                                        <i class="fa-light fa-key"></i>
                                        <span>@lang('2 FA Security')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-light fa-right-from-bracket"></i>
                                        <span>@lang('Sign Out')</span>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
