@if(isset($dark_buy_game_id))
    <section class="buy-game-id-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <div data-aos="fade-up" data-aos-duration="500">
                    <h2>{{ $dark_buy_game_id['single']['title'] ?? '' }}</h2>
                    <p class="mb-0">{{ $dark_buy_game_id['single']['sub_title'] ?? '' }}</p>
                </div>
                <a href="{{ $dark_buy_game_id['single']['media']->button_link }}" class="kew-btn" data-aos="fade-up" data-aos-duration="700">
                    <span class="kew-text">{{ $dark_buy_game_id['single']['button'] ?? ' ' }}</span>
                    <div class="kew-arrow">
                        <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                        <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                    </div>
                </a>
            </div>

            <div class="row g-3 g-sm-4 justify-content-center">
                @foreach($dark_buy_game_id['gameCategory'] as $item)
                    @if(isset($item['details']) && isset($item['details']['name']))
                        <div class="col-xl-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="500">
                            <div class="category-box">
                                <a href="{{ route('buy', ['category' => Str::slug($item['details']['name'])]) }}" class="img-box">
                                    <img src="{{ getFile($item['image_driver'], $item['image']) }}" alt="{{ $item['details']['name'] }}" />
                                </a>
                                <div class="text-box">
                                    <a href="{{ route('buy', ['category' => Str::slug($item['details']['name'])]) }}" class="title">{{ $item['details']['name'] }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </section>
@endif
