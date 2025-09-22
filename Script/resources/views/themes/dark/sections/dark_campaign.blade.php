@if(isset($dark_campaign) && $dark_campaign['campaign']['status']
    && $dark_campaign['campaign']['start_date'] <= \Carbon\Carbon::now()
    && $dark_campaign['campaign']['end_date'] >= \Carbon\Carbon::now())
    <section class="flash-deal-section">
        <div class="container">
            <div class="flash-deal-section-inner">
                <div class="row g-4 g-xl-5 justify-content-between">
                    <!-- Left Side -->
                    <div class="col-xl-4" data-aos="fade-up" data-aos-duration="500">
                        <div class="left-side">
                            <div class="img-box">
                                <img
                                    src="{{ getFile($dark_campaign['single']['media']->image->driver, $dark_campaign['single']['media']->image->path) }}"
                                    alt="flash-img"/>
                            </div>
                            <div class="text-box">
                                <h3>{{ $dark_campaign['single']['heading'] ?? '' }}</h3>
                                <div class="countdown mt-20"></div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const endDate = "{{ $dark_campaign['campaign']->end_date ?? '' }}";
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
                            </div>
                        </div>
                    </div>
                    <!-- Right Side -->
                    <div class="col-xl-8" data-aos="fade-up" data-aos-duration="700">
                        <div class="text-center text-md-start">
                            <h3>{{ $dark_campaign['single']['title'] ?? '' }}</h3>
                            <p>{{ $dark_campaign['single']['sub_title'] ?? '' }}</p>
                        </div>
                        <!-- Carousel -->

                        <div class="owl-carousel owl-theme trending-offers-carousel mt-30">
                            @php($itemsPerRow = 4)
                            @if(!empty($dark_campaign['trendingTopUpServices']))
                                @foreach($dark_campaign['trendingTopUpServices']->chunk($itemsPerRow) as $chunk)
                                    <div class="item">
                                        <div class="row g-3 g-sm-4">
                                            @foreach($chunk as $service)
                                                <div class="col-md-6">
                                                    <a href="{{ $service->topUp->top_up_detail_route ?? '#' }}"
                                                       class="product-box">
                                                        <div class="img-box">
                                                            <img src="{{ optional($service->topUp)->preview_image }}"
                                                                 alt="{{ $service->name }}"/>
                                                        </div>
                                                        <div class="text-box">
                                                            <div class="top-info">
                                                                <div class="review">
                                                                    <div
                                                                        class="reviews d-flex align-items-center gap-2 flex-wrap">
                                                                        <div>
                                                                            {!! displayStarRating($service->topUp->avg_rating ?? 0) !!}
                                                                        </div>
                                                                        <span>{{ number_format($service->topUp->total_review ?? 0) }} (@lang('reviews'))</span>
                                                                    </div>
                                                                </div>
                                                                <div class="title mt-10">{{ $service->name }}</div>
                                                            </div>
                                                            <div class="bottom-info">
                                                                <div class="price">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <div
                                                                            class="promo-price">{{ userCurrencyPosition(showActualPrice($service)) }}</div>
                                                                        <div
                                                                            class="original-price line-through">{{ userCurrencyPosition($service->price) }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if(!empty($dark_campaign['trendingCardServices']))
                                @foreach($dark_campaign['trendingCardServices']->chunk($itemsPerRow) as $chunk)
                                    <div class="item">
                                        <div class="row g-3 g-sm-4">
                                            @foreach($chunk as $service)
                                                <div class="col-md-6">
                                                    <a href="{{ $service->card->card_detail_route ?? '#' }}"
                                                       class="product-box">
                                                        <div class="img-box">
                                                            <img src="{{ optional($service->card)->preview_image }}"
                                                                 alt="{{ $service->name }}"/>
                                                        </div>
                                                        <div class="text-box">
                                                            <div class="top-info">
                                                                <div class="review">
                                                                    <div
                                                                        class="reviews d-flex align-items-center gap-2 flex-wrap">
                                                                        <div>
                                                                            {!! displayStarRating($service->card->avg_rating ?? 0) !!}
                                                                        </div>
                                                                        <span>{{ number_format($service->card->total_review ?? 0) }} (@lang('reviews'))</span>
                                                                    </div>
                                                                </div>
                                                                <div class="title mt-10">{{ $service->name }}</div>
                                                            </div>
                                                            <div class="bottom-info">
                                                                <div class="price">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <div
                                                                            class="promo-price">{{ userCurrencyPosition(showActualPrice($service)) }}</div>
                                                                        <div
                                                                            class="original-price line-through">{{ userCurrencyPosition($service->price) }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif



