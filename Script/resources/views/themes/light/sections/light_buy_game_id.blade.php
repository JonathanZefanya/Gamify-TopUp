
@if(isset($light_buy_game_id))
    <section class="buy-game-id-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <div data-aos="fade-up" data-aos-duration="500">
                    <h2>{{ $light_buy_game_id['single']['title'] ?? '' }}</h2>
                    <p class="mb-0">{{ $light_buy_game_id['single']['sub_title'] ?? '' }}</p>
                </div>
                <a class="view-all-btn" href="{{ $light_buy_game_id['single']['media']->button_link }}" data-aos="fade-up" data-aos-duration="600">{{ $light_buy_game_id['single']['button'] }}<span><i
                            class="fa-regular fa-angle-right"></i></span></a>
            </div>
            <div class="row g-3 g-sm-4 justify-content-center">
                @foreach($light_buy_game_id['gameCategory'] as $item)
                    @if(isset($item['details']) && isset($item['details']['name']))
                        <div class="col-xl-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="500">
                            <a href="{{ route('buy', ['category' => Str::slug($item['details']['name'])]) }}" class="product-box">
                                <div class="img-box">
                                    <img src="{{ getFile($item['image_driver'], $item['image']) }}" alt="{{ $item['details']['name'] }}" />
                                </div>
                                <div class="text-box">
                                    <div class="top-info">
                                        <div class="title">
                                            {{ $item['details']['name'] ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif

