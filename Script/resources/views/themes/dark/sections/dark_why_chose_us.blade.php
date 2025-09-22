@if(isset($dark_why_chose_us))
    <section class="why-choose-us-section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-up" data-aos-duration="500">
                    <div class="text-box">
                        <h2>{{ @$dark_why_chose_us['single']['title'] }}</h2>
                        <p>{{ @$dark_why_chose_us['single']['sub_title'] }}</p>
                        <div class="cmn-list mt-30">
                            @foreach($dark_why_chose_us['multiple'] as $wcu)
                                <div class="item">
                                    <div class="icon-box">
                                        <i class="fa-solid fa-bolt"></i>
                                    </div>
                                    <div class="text-box">
                                        <h5>{{ @$wcu['title'] }}</h5>
                                        <p class="mb-0">{{ @$wcu['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-duration="500">
                    <div class="img-box">
                        <img src="{{ getFile($dark_why_chose_us['single']['media']->image->driver, $dark_why_chose_us['single']['media']->image->path) }}"
                             alt="why-choose-img">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

