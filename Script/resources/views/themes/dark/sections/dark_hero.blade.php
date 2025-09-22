
@if(isset($dark_hero))
    <section class="hero-section">
        <div class="container">
            <div class="row g-4 g-xxl-5">
                <div class="col-lg-8">
                    <!-- Swiper -->
                    <div class="swiper hero-swiper" data-aos="fade-up" data-aos-duration="500">
                        <div class="swiper-wrapper">
                            @foreach($dark_hero['multiple'] as $index => $item)
                                <style>
                                    .lime-green-box-{{ $index }}::after {
                                        background-image: url({{ getFile(@$item['media']->background_image->driver, @$item['media']->background_image->path) }});
                                    }
                                </style>
                                <div class="swiper-slide">
                                    <div class="slider-box lime-green-box lime-green-box-{{ $index }}">
                                        <div class="text-box">
                                            <div class="section-subtitle">
                                                @lang(@$item['sub_title'])
                                            </div>
                                            <h1 class="title">@lang(@$item['title'])</h1>
                                            <p class="description">@lang(@$item['description'])</p>
                                            <a href="" class="kew-btn mt-20">
                                                <span class="kew-text">{{ @$item['kew-text'] }}</span>
                                                <div class="kew-arrow">
                                                    <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                                                    <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div> -->
                        <div class="swiper-pagination"></div>
                        <div class="autoplay-progress">
                            <svg viewBox="0 0 48 48">
                                <circle cx="24" cy="24" r="20"></circle>
                            </svg>
                            <span></span>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="right-box">
                        <div class="text-center text-md-start">
                            <h4 data-aos="fade-up" data-aos-duration="500">@lang(@$dark_hero['single']['trend_title'])</h4>
                            <p class="mb-0" data-aos="fade-up" data-aos-duration="700">@lang(@$dark_hero['single']['trend_sub_title'])
                            </p>
                        </div>

                        <div class="owl-carousel owl-theme trending-offers-carousel mt-20" data-aos="fade-up"
                             data-aos-duration="900">
                            @foreach(array_chunk($dark_hero['trendingItems']->toArray(), 2) as $itemsChunk)
                                <div class="item">
                                    <div class="row g-3">
                                        @foreach($itemsChunk as $item)

                                            <div class="col-lg-12 col-md-6">
                                                <a href="{{ route('card.details', $item['card']['slug']) }}" class="product-box">
                                                    <div class="img-box">
                                                        <img src="{{ getFile($item['image_driver'], $item['image']) }}" alt="product-img">
                                                    </div>
                                                    <div class="text-box">
                                                        <div class="top-info">
                                                            <div class="review">
                                                                <div class="reviews d-flex align-items-center gap-2">
                                                                    <div>
                                                                        {!! displayStarRating($item['card']['avg_rating'] ?? null) !!}
                                                                    </div>
                                                                    <span>{{ optional($item['card'])->total_review??0 }} (@lang('reviews'))</span>
                                                                </div>
                                                            </div>
                                                            <div class="title mt-10">
                                                                {{ $item['name'] }}
                                                            </div>
                                                            <p class="name mt-1">{{ $item['card']['name'] ?? null }}</p>
                                                        </div>
                                                        <div class="bottom-info">
                                                            <div class="price">
                                                                @php
                                                                $discount = 0;
                                                                if ($item['discount'] && $item['price']) {
                                                                    if ($item['discount_type'] == 'percentage') {
                                                                        $discount = ($item['discount'] * $item['price']) / 100;
                                                                    } elseif ($item['discount_type'] == 'flat') {
                                                                        $discount = $item['discount'];
                                                                    }
                                                                }
                                                                @endphp
                                                                <div class="promo-price">{{ userCurrencyPosition(@$item['price'] - $discount) }}</div>
                                                                <div class="sell">
                                                                    <i class="fa-regular fa-shopping-cart"></i>{{ formatNumber($item['card']['total_review'] ?? 0) }}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
