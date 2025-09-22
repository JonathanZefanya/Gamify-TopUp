<!-- Trending game section start -->
@if(isset($light_top_up))
    <section class="trending-game-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <div data-aos="fade-up" data-aos-duration="500">
                    <h2>{{ $light_top_up['single']['title'] ?? ' ' }}</h2>
                    <p class="mb-0">{{ $light_top_up['single']['sub_title'] ?? ' ' }}</p>
                </div>
                <a class="view-all-btn" href="{{ $light_top_up['single']['media']->button_link ?? '#' }}" data-aos="fade-up" data-aos-duration="600">@lang($light_top_up['single']['button'] ?? ' ') <span><i
                            class="fa-regular fa-angle-right"></i></span></a>
            </div>
            <div class="row">
                @foreach($light_top_up['trendingItems'] as $item)
                    <div class="col-xl-2 col-lg-3 col-md-4" data-aos="fade-up" data-aos-duration="500">
                        <a href="{{ $item->top_up_detail_route }}" class="product-box">
                            <div class="img-box">
                                <img src="{{ $item->preview_image }}" alt="{{ $item->name ?? ' ' }}" />
                            </div>
                            <div class="text-box">
                                <div class="top-info">
                                    <div class="title">
                                        {{ $item->name ?? ' ' }}
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

<!-- Trending game section end -->
