<!-- Hero section start -->
@if(isset($light_hero))
    <div class="hero-section">
        <div class="swiper hero-swiper" data-aos="fade-up" data-aos-duration="500">
            <div class="swiper-wrapper">
                @foreach($light_hero['multiple'] as $item)
                    <div class="swiper-slide">
                        <div class="slider-box">
                            <div class="img-box">
                                <img class="img-1"
                                     src="{{ getFile(@$item['media']->image->driver, @$item['media']->image->path) }}"
                                     alt="@lang('hero image one')">
                                <img class="img-2"
                                     src="{{ getFile(@$item['media']->image_two->driver, @$item['media']->image_two->path) }}"
                                     alt="@lang('hero image two')">
                                <div class="img-inner">
                                    <img class="main-img"
                                         src="{{ getFile(@$item['media']->image_three->driver, @$item['media']->image_three->path) }}"
                                         alt="@lang('hero image three')">
                                </div>
                            </div>
                            <div class="text-box">
                                <div class="text-box-inner">
                                    <div class="section-subtitle">
                                        @lang($item['title'] ?? ' ')
                                    </div>
                                    <h1 class="title">{{ $item['sub_title'] ?? ' ' }}</h1>
                                    <p class="description">{{ $item['description'] ?? ' ' }}</p>
                                    <a href="{{ $item['media']->button_link }}" class="cmn-btn mt-20">{{ $item['button'] }}<i
                                            class="fa-regular fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="autoplay-progress">
                <svg viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="20"></circle>
                </svg>
                <span></span>
            </div>
        </div>
    </div>
@endif

