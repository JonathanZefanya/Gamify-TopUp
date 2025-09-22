@if(isset($dark_top_up))
    <section class="trending-game-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <div data-aos="fade-up" data-aos-duration="500">
                    <h2>{{ @$dark_top_up['single']['title'] }}</h2>
                    <p class="mb-0">{{ @$dark_top_up['single']['sub_title'] }}</p>
                </div>
                <a href="{{ route('top-up') }}" class="kew-btn" data-aos="fade-up" data-aos-duration="700">
                    <span class="kew-text">{{ @$dark_top_up['single']['button'] }}</span>
                    <div class="kew-arrow">
                        <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                        <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                    </div>
                </a>
            </div>
            <div class="row g-3 g-sm-4 justify-content-start">
                @foreach($dark_top_up['trendingItems'] as $item)
                    <div class="col-xl-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="500">
                        <div class="category-box">
                            <a href="{{ $item->top_up_detail_route }}" class="img-box">
                                <img src="{{ $item->preview_image }}" alt="product-img" />
                            </a>
                            <div class="text-box">
                                <a href="{{ $item->top_up_detail_route }}" class="title">{{ $item->name ?? null }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

