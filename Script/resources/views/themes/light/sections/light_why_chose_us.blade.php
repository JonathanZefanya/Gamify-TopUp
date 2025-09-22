<!-- Why choose us section start -->
@if(isset($light_why_chose_us))
    <section class="why-choose-us-section">
        <div class="container">
            <div class="row g-4 g-sm-5 align-items-center">
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500">
                    <div class="img-box">
                        <img src="{{ getFile($light_why_chose_us['single']['media']->image->driver,  $light_why_chose_us['single']['media']->image->path)}}"
                             alt="why-choose-img">
                    </div>
                </div>
                <div class="col-lg-8" data-aos="fade-up" data-aos-duration="500">
                    <div class="text-box">
                        <h2>{{ $light_why_chose_us['single']['title'] ?? ' ' }}</h2>
                        <p>{{ $light_why_chose_us['single']['sub_title'] ?? ' ' }}</p>
                        <a href="{{ $light_why_chose_us['single']['media']->button_link }}" class="cmn-btn mt-10">{{ $light_why_chose_us['single']['button'] ?? ' ' }}<i class="fa-regular fa-arrow-right-long"></i></a>
                        <div class="mt-30">
                            <div class="row g-4">
                                @foreach($light_why_chose_us['multiple'] as $item)
                                    <div class="col-md-6">
                                        <div class="cmn-box">
                                            <h5>{{ $item['title'] }}</h5>
                                            <p class="mb-0">{{ $item['description'] }}</p>
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

<!-- Why choose us section end -->
