<!-- Flash deal section start -->
@if(isset($light_campaign))
    <section class="flash-deal-section">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-center justify-content-between">
                <div class="col-lg-4">
                    <div class="left-side" data-aos="fade-up" data-aos-duration="500">
                        <h3 class="text-center">{{ $light_campaign['single']['heading'] ?? '' }}</h3>
                        <div class="countdown mt-20"></div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const endDate = "{{ $light_campaign['campaign']->end_date ?? '' }}";
                                if (endDate) {
                                    if ($('.countdown').length) {
                                        $('.countdown').countdown(endDate, function (event) {
                                            $(this).html(event.strftime(
                                                '<div class="single-countdown"><h5>%D</h5><span>Days</span></div>' +
                                                '<div class="single-countdown"><h5>%H</h5><span>Hours</span></div>' +
                                                '<div class="single-countdown"><h5>%M</h5><span>Minutes</span></div>' +
                                                '<div class="single-countdown"><h5>%S</h5><span>Seconds</span></div>'
                                            ));
                                        });
                                    }
                                } else {
                                    console.error('End date is not defined or invalid.');
                                }
                            });
                        </script>
                        <div class="flash-product-box mt-20" data-aos="fade-up" data-aos-duration="700">
                            <a href="{{ $light_campaign['trendingFirstItem']['topUp']['top_up_detail_route'] ?? '#' }}"
                               class="img-box">
                                <img src="{{ $light_campaign['trendingFirstItem']['topUp']['preview_image'] }}" alt="">
                            </a>
                            @if(isset($light_campaign['trendingFirstItem']))
                                <div class="text-box mt-30">
                                    <a href="{{ $light_campaign['trendingFirstItem']['topUp']['top_up_detail_route'] ?? '#' }}"
                                       class="title">{{ $light_campaign['trendingFirstItem']['name'] }}</a>
                                    <div class="mt-10 d-flex justify-content-between align-items-center gap-2">
                                        <div>
                                            <div
                                                class="promo-price">{{ userCurrencyPosition(showActualPrice($light_campaign['trendingFirstItem'])) }}</div>
                                            <div
                                                class="original-price line-through">{{ userCurrencyPosition($light_campaign['trendingFirstItem']->price) }}</div>
                                        </div>
                                        <a href="{{ $light_campaign['trendingFirstItem']['topUp']['top_up_detail_route'] ?? '#' }}"
                                           class="cart-btn-sm">
                                            <i class="fa-regular fa-cart-shopping"></i>
                                        </a>
                                    </div>
                                    <div class="discount">@lang('Save')
                                        : {{ ($light_campaign['trendingFirstItem']['discount_type'] == 'percentage') ? '-'.$light_campaign['trendingFirstItem']['discount'].'%' : userCurrencyPosition($light_campaign['trendingFirstItem']['discount']) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" data-aos="fade-up" data-aos-duration="700">
                    <div class="text-center text-md-start">
                        <h3>{{ $light_campaign['single']['title'] ?? '' }}</h3>
                        <p>{{ $light_campaign['single']['sub_title'] ?? '' }}</p>
                    </div>

                    <div class="owl-carousel owl-theme flash-sale-carousel mt-30">
                        @if(!empty($light_campaign['trendingTopUpServices']))
                            @foreach($light_campaign['trendingTopUpServices'] as $item)

                                <div class="item">
                                    <a href="{{ $item->topUp->top_up_detail_route ?? '#' }}" class="product-box">
                                        <div class="img-box">
                                            <img src="{{ optional($item->topUp)->preview_image }}"
                                                 alt="{{ $item->name }}"/>
                                        </div>
                                        <div class="text-box">
                                            <div class="top-info">
                                                <div class="title">
                                                    {{ $item->name }}
                                                </div>
                                            </div>
                                            <div class="bottom-info">
                                                <div class="price">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div
                                                            class="promo-price">{{ userCurrencyPosition(showActualPrice($item)) }}</div>
                                                        <div
                                                            class="original-price line-through">{{ userCurrencyPosition($item->price) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="discount">{{ ($item['discount_type'] == 'percentage') ? '-'.$item['discount'].'%' : userCurrencyPosition($item['discount'])  }}</div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                        @if(!empty($light_campaign['trendingCardServices']))
                            @foreach($light_campaign['trendingCardServices'] as $item)

                                <div class="item">
                                    <a href="{{ $item->card->card_detail_route ?? '#' }}" class="product-box">
                                        <div class="img-box">
                                            <img src="{{ optional($item->card)->preview_image }}"
                                                 alt="{{ $item->name }}"/>
                                        </div>
                                        <div class="text-box">
                                            <div class="top-info">
                                                <div class="title">
                                                    {{ $item->name }}
                                                </div>
                                            </div>
                                            <div class="bottom-info">
                                                <div class="price">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div
                                                            class="promo-price">{{ userCurrencyPosition(showActualPrice($item)) }}</div>
                                                        <div
                                                            class="original-price line-through">{{ userCurrencyPosition($item->price) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="discount">{{ ($item['discount_type'] == 'percentage') ? '-'.$item['discount'].'%' : userCurrencyPosition($item['discount'])  }}</div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Flash deal section end -->
