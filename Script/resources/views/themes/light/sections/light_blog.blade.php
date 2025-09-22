@if(isset($light_blog))
    <section class="blog-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <h2 class="mb-0" data-aos="fade-up" data-aos-duration="500">@lang($light_blog['single']['title'] ?? '')</h2>
                <a class="view-all-btn" href="{{ $light_blog['single']['media']->button_link ?? '#' }}" data-aos="fade-up" data-aos-duration="600">@lang($light_blog['single']['button'] ?? 'view all') <span><i
                            class="fa-regular fa-angle-right"></i></span></a>
            </div>
            <div class="row gy-5 justify-content-center">
                @foreach($light_blog['multiple'] as $item)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="500">
                        <div class="blog-box">
                            <div class="text-box">
                                <h5 class="title">
                                    <a class="border-effect" href="{{ route('blog.details', $item->slug) }}">{{ optional($item->category)->name }}</a>
                                </h5>
                                <ul class="meta">
                                    <li class="item">
                                        <span class="icon"><i class="fa-light fa-calendar-days"></i></span>
                                        <span>{{ dateTime($item->created_at) }}</span>
                                    </li>
                                    <li class="item tag">
                                        <a href="{{route('blog', optional($item->category)->slug)}}">{{ optional($item->category)->name }}</a>
                                    </li>
                                </ul>
                            </div>
                            <a class="img-box" href="{{ route('blog.details', $item->slug) }}">
                                <img src="{{ getFile($item->blog_image_driver, $item->blog_image) }}" alt="blog-img">
                            </a>
                            <p class="mt-20 mb-0">{{ Str::limit(strip_tags($item->details?->description), 120, '...') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

