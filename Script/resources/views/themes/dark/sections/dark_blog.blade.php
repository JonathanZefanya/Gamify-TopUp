@if(isset($dark_blog))
    <section class="blog-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h2 class="mb-0" data-aos="fade-up" data-aos-duration="500">{{ @$dark_blog['single']['title'] }}</h2>
                <a href="{{ @$dark_blog['single']['media']->button_link }}" class="kew-btn" data-aos="fade-up" data-aos-duration="700">
                    <span class="kew-text">{{ @$dark_blog['single']['button'] }}</span>
                    <div class="kew-arrow">
                        <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                        <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                    </div>
                </a>
            </div>
            <div class="row g-4 justify-content-center g-4 mt-20">
                @foreach($dark_blog['multiple'] as $item)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="500">
                        <div class="blog-box">
                            <a class="img-box" href="{{ route('blog.details', $item->slug) }}">
                                <img src="{{ getFile($item->blog_image_driver, $item->blog_image) }}" alt="blog-img">
                            </a>
                            <div class="text-box">
                                <ul class="meta">
                                    <li class="item">
                                        <span class="icon"><i class="fa-light fa-calendar-days"></i></span>
                                        <span>{{ dateTime($item->created_at) }}</span>
                                    </li>
                                    <li class="item tag">
                                        <a href="{{route('blog', $item->slug)}}">{{ optional($item->category)->name }}</a>
                                    </li>
                                </ul>
                                <h5 class="title">
                                    <a class="border-effect" href="{{ route('blog.details', $item->slug) }}">
                                        {{ optional($item->details)->title }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

