<!-- Trending offer section start -->
@if(isset($light_trending_item))
    <section class="trending-offer-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center text-md-start">
                        <h4 data-aos="fade-up" data-aos-duration="500">@lang($light_trending_item['single']['title'] ?? ' ')</h4>
                        <p class="mb-0" data-aos="fade-up" data-aos-duration="700">{{ $light_trending_item['single']['sub_title'] ?? 0 }}</p>
                    </div>

                    <div class="owl-carousel owl-theme trending-items-carousel mt-20" data-aos="fade-up"
                         data-aos-duration="900">
                        @foreach($light_trending_item['trendingItems'] as $item)
                            <div class="item">
                                <a href="{{ $item->card_detail_route ?? '#' }}" class="product-box">
                                    <div class="img-box">
                                        <img src="{{ $item->preview_image }}" alt="{{ $item->name ?? ' ' }}">
                                    </div>
                                    <div class="text-box">
                                        <div class="top-info">
                                            <div class="title">
                                                {{ $item->name ?? ' ' }}
                                            </div>
                                        </div>
                                        <div class="bottom-info">
                                            <div class="price">
                                                <div class="promo-price">{{ userCurrencyPosition($item->serviceWithLowestPrice()->price - $item->serviceWithLowestPrice()->getDiscount()) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Trending offer section end -->
