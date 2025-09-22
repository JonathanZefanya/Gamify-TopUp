<!-- Exclusive offer section start -->
@if(isset($light_exclusive_card))
    <section class="exclusive-offer-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <div>
                    <h3>@lang($light_exclusive_card['single']['title'] ?? ' ')</h3>
                    <p class="mb-0">{{ $light_exclusive_card['single']['sub_title'] ?? ' ' }}</p>
                </div>
                <a class="view-all-btn" href="{{ $light_exclusive_card['single']['media']->button_link }}">@lang($light_exclusive_card['single']['button'])<sapn><i class="fa-regular fa-angle-right"></i></sapn></a>
            </div>
            <div class="row">
                @foreach($light_exclusive_card['cards'] as $item)
                    <div class="col-xl-2 col-lg-3 col-md-4" data-aos="fade-up" data-aos-duration="500">
                        <a href="{{ $item['card_detail_route'] ?? '#' }}" class="product-box">
                            <div class="img-box">
                                <img src="{{ $item['preview_image'] ?? ' ' }}" alt="{{ @$item['name'] ?? ' ' }}" />
                            </div>
                            <div class="text-box">
                                <div class="top-info">
                                    <div class="title">
                                        {{ @$item['name'] ?? ' ' }}
                                    </div>
                                </div>
                                <div class="bottom-info">
                                    <div class="price">
                                        <div class="promo-price">{{ userCurrencyPosition($item->serviceWithLowestPrice()->price - $item->serviceWithLowestPrice()->getDiscount()) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="discount"><i class="fa-regular fa-shopping-cart pe-1"></i>{{ formatNumber($item['sell_count']) }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Exclusive offer section enn -->
