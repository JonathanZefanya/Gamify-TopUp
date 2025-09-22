@guest
    <div class="header-login">
        <a href="javascript:void(0)" class="btn-1">@lang('Log In/Sign Up') <span></span></a>
        <div class="login-dropdown">
            <div class="login-dropdown-image">
                <img src="{{asset($themeTrue.'images/useful/welcome.webp')}}" alt="gamot">
            </div>
            <p>@lang('Welcome to') {{basicControl()->site_title}}</p>
            <div class="login-dropdown-btn">
                <a href="{{route('login')}}" class="btn-1">@lang('Log In') <span></span></a>
                <a href="{{route('register')}}" class="btn-1">@lang('Sign Up') <span></span></a>
            </div>
        </div>
    </div>
@endguest
@auth
    <div class="header-user">
        <div class="header-cart">
            <a href="{{route('cart.user.fetch')}}">
                <i class="fa-light fa-cart-shopping"></i>
                <div class="header-cart-notification">
                    04
                </div>
            </a>
        </div>

        <div class="header-cart">
            <a href="{{route('user.dashboard')}}">
                <div class="header-user-dropdown-icon">
                    <i class="fa-light fa-user"></i>
                </div>
            </a>
        </div>
    </div>

    @push('script')
        <script>
            'use strict';
            cartCount();

            function cartCount() {
                axios.get("{{route('cart.user.cartCount')}}")
                    .then(function (res) {
                        if (res.data.status) {
                            $('.header-cart-notification').text(res.data.cartCount);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        </script>
    @endpush
@endauth
