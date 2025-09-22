<section class="about-section">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="500">
                <div class="img-box">
                    <img src="{{ getFile($dark_about['single']['media']->image->driver, $dark_about['single']['media']->image->path) }}" alt="about-img" />
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="700">
                <div class="text-box">
                    <h2 class="mb-20">{{ @$dark_about['single']['title'] }}</h2>
                    {!! $dark_about['single']['description'] !!}
                    <a href="{{ $dark_about['single']['media']->button_link }}" class="kew-btn mt-30">
                        <span class="kew-text">{{ $dark_about['single']['button'] }}</span>
                        <div class="kew-arrow">
                            <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                            <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
