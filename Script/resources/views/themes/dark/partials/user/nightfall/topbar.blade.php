<!-- Header section start -->
<header id="header" class="header">
    <button class="toggle-sidebar-btn d-none d-xl-block"><i class="fa-light fa-list text-light"></i></button>
    <!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center">
            <input type="search" class="form-control global-search" name="query" placeholder="@lang('Search')"
                   title="@lang('Enter search keyword')">
            <span class="search-icon" title="Search"><i class="fa-regular fa-magnifying-glass"></i></span>
            <div class="search-result d-none">
                <div class="search-header">
                    @lang('Result')
                </div>
                <div class="content"></div>
            </div>
        </form>
    </div><!-- End Search Bar -->

    <!-- Start Icons Navigation -->
    <nav class="header-nav ms-auto">
        <ul class="nav-icons">

            @include(template().'partials.user.pushNotify')

            <li class="nav-item dropdown">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                   data-bs-toggle="dropdown">
                    <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                         alt="{{auth()->user()->fullname}}"
                         class="rounded-circle">
                    <span class="d-none d-xl-block dropdown-toggle ps-2">{{auth()->user()->fullname}}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header d-flex justify-content-center align-items-center text-start">
                        <div class="profile-thum">
                            <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                                 alt="{{auth()->user()->fullname}}">
                        </div>
                        <div class="profile-content">
                            <h6>{{auth()->user()->fullname}}</h6>
                            <span>{{auth()->user()->email}}</span>
                        </div>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center {{menuActive('user.profile')}}"
                           href="{{route('user.profile')}}">
                            <i class="fa-light fa-user"></i>
                            <span>@lang('My Profile')</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center {{menuActive('user.updatePassword')}}"
                           href="{{route('user.updatePassword')}}">
                            <i class="fa-sharp fa-light fa-lock"></i>
                            <span>@lang('Password Settings')</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center {{menuActive('user.kyc.settings')}}"
                           href="{{route('user.kyc.settings')}}">
                            <i class="fa-sharp fa-light fa-shield"></i>
                            <span>@lang('Identity Verification')</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center {{menuActive('user.notification.permission.list')}}"
                           href="{{route('user.notification.permission.list')}}">
                            <i class="fa-sharp fa-light fa-bell-on"></i>
                            <span>@lang('Notification Permission')</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center {{menuActive('user.twostep.security')}}"
                           href="{{route('user.twostep.security')}}">
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
    </nav>
</header>

