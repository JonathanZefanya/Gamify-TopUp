@extends(template() . 'layouts.app')
@section('title',trans('Blogs'))
@section('content')
    <section class="blog-section">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-30">
                <h2 class="mb-0" data-aos="fade-up" data-aos-duration="500">@lang('Updated Blogs Post')</h2>
            </div>
            @if(!empty($blogs))
                <div class="row gy-4 justify-content-center">
                    @foreach($blogs as $item)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="500">
                            <div class="blog-box">
                                <div class="text-box">
                                    <h5 class="title">
                                        <a class="border-effect" href="{{ route('blog.details',$item->slug) }}">{{ $item->details?->title }}</a>
                                    </h5>
                                    <ul class="meta">
                                        <li class="item">
                                            <span class="icon"><i class="fa-light fa-calendar-days"></i></span>
                                            <span>{{dateTime($item->created_at,'d M y')}}</span>
                                        </li>
                                        <li class="item tag">
                                            <a href="{{ route('blog', ['category' => $item->category->slug ]) }}">{{ $item->category?->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <a class="img-box" href="{{ route('blog.details', $item->slug ) }}">
                                    <img src="{{ getFile($item->blog_image_driver, $item->blog_image) }}" alt="@lang($item->details?->title)">
                                </a>
                                <p class="mt-20 mb-0">{{ Str::limit(strip_tags($item->details?->description), 98, '...') }}</p>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            {{ $blogs->appends($_GET)->links(template().'partials.pagination') }}
        </div>
    </section>
@endsection

