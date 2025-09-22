@if(isset($dark_testimonial))
    <section class="testimonial-section">
        <div class="container">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4 order-2 order-lg-1" data-aos="fade-up" data-aos-duration="500">
                        <div class="left-side mb-20 mb-lg-0">
                            <div class="text-center text-lg-start">
                                <h2 class="section-title mb-0">{{ @$dark_testimonial['single']['title'] }}</h2>
                                <a href="{{ @$dark_testimonial['single']['media']->button_link }}" class="kew-btn mt-30">
                                    <span class="kew-text">{{ @$dark_testimonial['single']['button'] }}</span>
                                    <div class="kew-arrow">
                                        <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                                        <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 order-1 order-lg-2" data-aos="fade-up" data-aos-duration="700">
                        <div class="right-side">
                            <div class="owl-carousel owl-theme testimonial-carousel">
                                @foreach($dark_testimonial['multiple'] as $item)
                                    <div class="item">
                                        <div class="testimonial-box">
                                            <div class="img-box">
                                                <img src="{{ getFile($item['media']->image->driver, $item['media']->image->path) }}"
                                                     alt="testimonial-img" />
                                            </div>
                                            <div class="text-box">
                                                <div class="d-flex justify-content-end">
                                                    <div class="quote-icon"><i class="fa-regular fa-quote-right"></i></div>
                                                </div>
                                                <ul class="reviews">
                                                    {!! displayStarRatingSection(@$item['rating'] ?? 0) !!}
                                                </ul>
                                                <p class="mt-20 mb-30">{{ @$item['review'] }}</p>
                                                <div class="profile-box">
                                                    <div class="profile-title">
                                                        <h5 class="mb-0">{{ @$item['name'] }}</h5>
                                                        <p class="mb-0">{{ @$item['location'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
