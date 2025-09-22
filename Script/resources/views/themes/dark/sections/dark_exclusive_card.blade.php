@if(isset($dark_exclusive_card))
    <section class="exclusive-offer-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <div>
                    <h3 data-aos="fade-up" data-aos-duration="500">{{ @$dark_exclusive_card['single']['title'] }}</h3>
                    <p class="mb-0" data-aos="fade-up" data-aos-duration="700">{{ @$dark_exclusive_card['single']['sub_title'] }}</p>
                </div>
                <a href="{{ $dark_exclusive_card['single']['media']->button_link }}" class="kew-btn" data-aos="fade-up" data-aos-duration="900">
                    <span class="kew-text">{{ @$dark_exclusive_card['single']['button'] }}</span>
                    <div class="kew-arrow">
                        <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                        <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                    </div>
                </a>
            </div>
            <div class="row g-3 g-sm-4">
                @foreach($dark_exclusive_card['cards'] as $item)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="500">
                        <a href="{{ $item['card_detail_route'] ?? '#' }}" class="product-box">
                            <div class="img-box">
                                <img src="{{ $item['preview_image'] ?? ' ' }}" alt="{{ @$item['name'] ?? ' ' }}" />
                            </div>
                            <div class="text-box">
                                <div class="top-info">
                                    <div class="review">
                                        <div class="reviews d-flex align-items-center gap-2">
                                            <div>
                                                {!! displayStarRating(@$item['avg_rating']) !!}
                                            </div>
                                            <span>{{ @$item->total_review }} (@lang('reviews'))</span>
                                        </div>
                                    </div>
                                    <div class="title mt-10">
                                        {{ @$item['name'] }}
                                    </div>
                                    <p class="name mt-1">{{ @$item['region'] }}</p>
                                </div>
                                <div class="bottom-info">
                                    <div class="price">
                                        <div class="promo-price">{{ userCurrencyPosition($item->serviceWithLowestPrice()->price - $item->serviceWithLowestPrice()->getDiscount()) }}</div>
                                        <div class="discount"><i class="fa-regular fa-shopping-cart pe-1"></i>{{ formatNumber($item['sell_count']) }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

