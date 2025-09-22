<!-- Header top section start -->
<div class="header-top-section">
    @php
        $socialData = getSocialData();
    @endphp
    <div class="container">
        <div class="top-bar">
            <ul class="contact-info">
                <li>
                    <a href="tel:{{ $socialData['single']->description->footer_phone ?? '' }}">
                        <i class="fa-regular fa-headphones"></i>
                        <span>{{ $socialData['single']->description->footer_phone ?? '' }}</span>
                    </a>
                </li>
                <li>
                    <a href="mailto:{{ $socialData['single']->description->footer_email ?? '' }}">
                        <i class="fa-regular fa-envelope-open"></i>
                        <span>{{ $socialData['single']->description->footer_email ?? '' }}</span>
                    </a>
                </li>
            </ul>
            <div class="right-side ">
                <ul class="social-box">
                    @foreach($socialData['multiple'] as $item)
                        <li><a href="{{ @$item['media']->my_link }}" aria-label="{{ @$item['name'] }}"><i
                                    class="{{ @$item['media']->icon }}"></i></a></li>
                    @endforeach
                </ul>
                <a class="lang-currency-btn"
                   data-lang_data="{{ json_encode($socialData['language']->map(function($lang) {
                       return [
                           'short_name' => $lang->short_name,
                           'name' => $lang->name,
                           'flag_url' => getFile($lang->flag_driver, $lang->flag),
                       ];
                   })) }}"
                   data-currency_data="{{ json_encode($socialData['currency']) }}"
                   data-route="{{ route('settingChange') }}"
                   data-active_currency="{{ $socialData['activeCurrency'] }}"
                   data-default_lang="{{ $socialData['defaultLanguage']['short_name'] }}"
                   data-bs-toggle="modal"
                   data-bs-target="#lang-currency-modal">
                    <img
                        src="{{ getFile($socialData['defaultLanguage']['flag_driver'] ,$socialData['defaultLanguage']['flag'])  }}"
                        alt="{{ $socialData['defaultLanguage']['name'] }}" class="activeLang">
                    {{ $socialData['defaultLanguage']['name'] }}
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Header top section end -->

<!-- Nav section start -->
<nav class="custom-navbar sticky-top">
    <div class="mobile-menu d-lg-none">
        <nav id="mobile-menu">
            <ul>
                {!! renderHeaderMenu(getHeaderMenuData()) !!}
            </ul>
        </nav>
    </div>
    <div class="desktop-view">
        <div class="container">
            <div class="desktop-view-wrapper">
                <a href="{{ route('page', '/') }}" class="logo"><img
                        src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}"
                        alt="{{ basicControl()->site_title }}"></a>
                <div class="main-menu d-none d-lg-block">
                    <nav>
                        <ul>
                            {!! renderHeaderMenu(getHeaderMenuData()) !!}
                        </ul>
                    </nav>
                </div>
                <ul class="custom-nav">
                    <li class="nav-item">
                        <div class="search-box2 headerSearch" id="search-box2">
                            <input type="text" id="search-input" class="form-control" placeholder="Search here..."
                                   autocomplete="off">
                            <div class="search-btn2"><i class="far fa-search"></i></div>
                            <div class="search-result" id="search-result">
                            </div>

                            @push('script')
                                <script>
                                    'use strict';
                                    const searchInput = document.getElementById('search-input');
                                    const resultsContainer = document.getElementById('search-result');

                                    searchInput.addEventListener('input', function () {
                                        const searchTerm = searchInput.value.trim();
                                        if (searchTerm.length > 0) {
                                            axios.get('{{ route('navSearch') }}', {
                                                params: {query: searchTerm}
                                            })
                                                .then(response => {
                                                    resultsContainer.innerHTML = '';
                                                    if (Array.isArray(response.data)) {
                                                        response.data.forEach(item => {
                                                            const resultItem = document.createElement('a');
                                                            resultItem.href = item.details_route;
                                                            resultItem.classList.add('search-item');

                                                            resultItem.innerHTML = `
                                                            <div class="img-area">
                                                                <img src="${item.preview}" alt="${item.name}">
                                                            </div>
                                                            <div class="text-area">
                                                                <div class="title">${item.name}</div>
                                                                <div class="sub-title">${item.typeOf}</div>
                                                            </div>
                                                        `;

                                                            resultsContainer.appendChild(resultItem);
                                                        });
                                                    } else {
                                                        console.error('Expected an array but got:', response.data);
                                                        resultsContainer.innerHTML = '<div class="text-area p-3"><p class="mb-0">@lang('No results found.')</p></div>';
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching search results:', error);
                                                    resultsContainer.innerHTML = '<p>@lang('Error occurred while searching.')</p>';
                                                });
                                        } else {
                                            resultsContainer.innerHTML = '<div class="text-area p-3"><p class="mb-0">@lang('No results found.')</p></div>';
                                        }
                                    });

                                    searchInput.addEventListener('focus', function () {
                                        if (searchInput.value.trim().length === 0) {
                                            resultsContainer.innerHTML = '<div class="text-area p-3"><p class="mb-0">@lang('Start typing to search...')</p></div>';
                                        }
                                    });

                                    searchInput.addEventListener('blur', function () {
                                        if (searchInput.value.trim().length === 0) {
                                            resultsContainer.innerHTML = '';
                                        }
                                    });
                                </script>
                            @endpush
                        </div>
                    </li>
                    @auth
                        <li class="nav-item">
                            <div class="shopping-cart">
                                <button class="dropdown-toggle">
                                    <div class="icon"><i class="fal fa-shopping-cart" aria-hidden="true"></i></div>
                                    <span class="count header-cart-notification">0</span>
                                </button>
                                <ul class="cart-dropdown">
                                    <div class="menu-cart-top">
                                        <h5 class="mb-0">@lang('Products in cart')</h5>
                                        <h5 class="menu-cart-top-count mb-0">0</h5>
                                    </div>
                                    <div class="dropdown-box cartItemsNav">

                                    </div>
                                    <div class="cart-bottom">
                                        <div class="sub-total total d-flex gap-2">@lang('Subtotal'):
                                            <span class="subTotal" id="subTotal">0</span>
                                            <span class="ps-1 discountAmountSpan">(
                                                <span class="discountAmount" id="discountAmount"></span>
                                                <span class="ps-1">@lang(' Discount')</span>
                                                )
                                                </span>
                                        </div>
                                        <div class="btn-area d-flex justify-content-between gap-2">
                                            <a href="{{ route('cart.user.fetch') }}"
                                               class="cmn-btn w-100"><span>@lang('View cart')</span></a>
                                            <a href="#" class="cmn-btn2 w-100" id="checkoutButton">@lang('checkout')</a>
                                            <form id="checkoutForm" action="{{ route('card.user.buy') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </li>

                        @push('script')
                            <script>
                                'use strict';
                                document.getElementById('checkoutButton').addEventListener('click', function (e) {
                                    e.preventDefault();
                                    document.getElementById('checkoutForm').submit();
                                });
                                cartCount();

                                function cartCount() {
                                    axios.get("{{route('cart.user.cartCount')}}")
                                        .then(function (res) {
                                            if (res.data.status) {
                                                $('.header-cart-notification').text(res.data.cartCount);

                                                if (res.data.cartCount > 0) {
                                                    const sessionCard = res.data.sessionCard;
                                                    const dropdownBox = $('.cartItemsNav');
                                                    dropdownBox.empty();

                                                    Object.values(sessionCard).forEach(item => {
                                                        const actualPrice = item.actualPrice;
                                                        const quantity = parseInt(item.quantity, 10);

                                                        const cartItemHtml = `
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <img src="${item.image}" alt="dropdown-img">
                                                                <div class="text">
                                                                    <h6 class="title active">${item.name}</h6>
                                                                    <small class="price-quantity">${quantity} × ${actualPrice}</small>
                                                                </div>
                                                                <button class="close" type="button" data-id="${item.id}" onclick="remove(this)">
                                                                    <i class="fal fa-times" aria-hidden="true"></i>
                                                                </button>
                                                            </a>
                                                        </li>`;
                                                        dropdownBox.append(cartItemHtml);
                                                    });
                                                    $('.menu-cart-top-count').text(res.data.cartCount);
                                                    const subtotal = res.data.subTotal;
                                                    const discountAmount = res.data.totalDiscountAmount;

                                                    $('.subTotal').text(subtotal);
                                                    $('.discountAmount').text(discountAmount);
                                                }
                                            }

                                        })
                                        .catch(function (error) {
                                            console.error(error);
                                        });
                                }

                                function remove(buttonElement) {
                                    let removeProductId = $(buttonElement).data('id');

                                    axios.post("{{ route('cart.user.remove') }}", {
                                        serviceId: removeProductId,
                                    })
                                        .then(function (response) {
                                            if (response.data.status) {
                                                cartCount();
                                                Notiflix.Notify.success(response.data.message);
                                            } else {
                                                Notiflix.Notify.failure(response.data.message);
                                            }
                                        })
                                        .catch(function (error) {
                                            console.error(error);
                                        });
                                }
                            </script>
                        @endpush
                        @include(template().'partials.user.pushNotify')
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link login-btn" href="{{ route('login') }}" aria-label="login-btn">
                                <span class="icon d-sm-block d-lg-none">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    @lang('Login')
                                </span>
                                <span class="d-none d-lg-block">
                                    @lang('Login')
                                </span>
                            </a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <div class="profile-box">
                                <div class="profile">
                                    <img src="{{ getFile(auth()->user()->image_driver, auth()->user()->image) }}"
                                         class="{{ auth()->user()->firstname.' '.auth()->user()->lastname }}"
                                         alt="GEMOt">
                                </div>
                                <ul class="user-dropdown">
                                    <li>
                                        <a href="{{ route('user.dashboard') }}"> <i
                                                class="fal fa-user"></i> @lang('Dashbord') </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.ticket.list') }}"> <i
                                                class="fal fa-user-headset"></i> @lang('Support') </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.profile') }}"> <i
                                                class="fal fa-user-cog"></i>@lang('Account Settings')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fal fa-sign-out-alt"></i>
                                            @lang('Sign Out')
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endauth

                </ul>
            </div>

        </div>
    </div>
</nav>
<!-- Nav section end -->

<!-- Modal section start -->
<div class="modal fade" id="lang-currency-modal" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">@lang('Select Language and Currency')</h4>
                <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="modal-body">
                    <form action="{{route('settingChange')}}" method="POST">
                        @csrf

                        @if(isset($languages) && !empty($languages))
                            <div class="row g-4">
                                <div class="col-12">
                                    <div id="formModal">
                                        <label class="form-label">@lang('Select language')</label>
                                        <select class="modal-select2-image langContainer" name="language">
                                            @foreach($languages as $language)
                                                <option value="{{$language->short_name}}"
                                                        data-flag="{{getFile($language->flag_driver,$language->flag)}}"
                                                    {{session()->get('lang') == $language->short_name ? 'selected':''}}>
                                                    {{$language->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(isset($currencies) && !empty($currencies))
                            <div class="row g-4">
                                <div class="col-12">
                                    <div id="formModal">
                                        <label class="form-label">@lang('Select Currency')</label>
                                        <select class="modal-select2-image currencyContainer" name="currency">
                                            @foreach($currencies as $currecy)
                                                <option value="{{$currecy->id}}"
                                                    {{session()->get('currency_code') == $currecy->code ? 'selected':''}}>
                                                    {{$currecy->name}}
                                                    ({{$currecy->symbol}})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="mt-10">
                            <button type="submit" class="cmn-btn w-100 mt-10">@lang('save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .discountAmountSpan {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
</style>

