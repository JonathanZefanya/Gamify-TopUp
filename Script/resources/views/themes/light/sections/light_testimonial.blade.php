<!-- Testimonial section start -->
@if(isset($light_testimonial))
    <section class="testimonial-section">
        <div class="container">
            <div class="row g-4 g-xxl-5 align-items-center justify-content-between">
                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="900">
                    <div class="img-box"><img src="{{ getFile($light_testimonial['single']['media']->image->driver, $light_testimonial['single']['media']->image->path) }}" alt="@lang('Testimonial Image')"></div>
                </div>
                <div class="col-lg-6">
                    <div class="right-side">
                        <div class="text-center text-md-start">
                            <h2 class="section-title" data-aos="fade-up" data-aos-duration="700"> @lang($light_testimonial['single']['title'] ?? ' ')</h2>
                            <p class="mt-10 mb-10 cmn-para-text" data-aos="fade-up" data-aos-duration="900">@lang($light_testimonial['single']['sub_title'] ?? ' ')</p>
                        </div>
                        <div class="owl-carousel owl-theme testimonial-carousel">
                            @foreach($light_testimonial['multiple'] as $item)
                                <div class="item" data-aos="fade-up" data-aos-duration="500">
                                    <div class="testimonial-box">
                                        <div class="reviews">
                                            <div>
                                                {!! displayStarRatingSection($item['rating'] ?? 0) !!}
                                            </div>
                                        </div>

                                        <div class="quote-area">
                                            <p>{{ $item['review'] ?? '' }}</p>
                                        </div>
                                        <div class="profile-box">
                                            <div class="profile-thumbs">
                                                <img src="{{ getFile($item['media']->image->driver, $item['media']->image->path) }}" alt="{{ $item['name'] ?? ' ' }}" />
                                            </div>
                                            <div class="profile-title">
                                                <h6 class="mb-0">@lang($item['name'] ?? ' ')</h6>
                                                <p class="mb-0">@lang($item['location'] ?? ' ')</p>
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
    </section>
@endif

<!-- Testimonial section end -->
