<!-- About section start -->
@if(isset($light_about))
    <section class="about-section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="500">
                    <div class="img-box">
                        <img src="{{ getFile($light_about['single']['media']->image->driver, $light_about['single']['media']->image->path) }}"
                             alt="about-img" />
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="700">
                    <div class="text-box">
                        <h2 class="mb-20">@lang($light_about['single']['title'])</h2>
                        {!! $light_about['single']['description'] !!}
                        <a href="{{ $light_about['single']['media']->button_link }}" class="cmn-btn mt-20">@lang($light_about['single']['button'])<i class="fa-regular fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- About section end -->
