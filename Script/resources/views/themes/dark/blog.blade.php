@extends(template() . 'layouts.app')
@section('title',trans('Blogs'))
@section('content')

    <section class="blog-section">
        <div class="container">
            @if(!empty($blogs))
                <div class="row g-4 justify-content-center">
                    @foreach($blogs as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-box">
                                <a class="img-box" href="{{ route('blog.details',slug($item->slug)) }}">
                                    <img src="{{ getFile($item->blog_image_driver,$item->blog_image) }}" alt="@lang($item->details?->title)">
                                </a>
                                <div class="text-box">
                                    <ul class="meta">
                                        <li class="item">
                                            <span class="icon"><i class="fa-light fa-calendar-days"></i></span>
                                            <span>{{dateTime($item->created_at,'d M y')}}</span>
                                        </li>
                                        <li class="item tag">
                                            <a href="{{ route('blog', ['category' => $item->category->slug ]) }}">{{ $item->category?->name }}</a>
                                        </li>
                                    </ul>
                                    <h5 class="title">
                                        <a class="border-effect" href="{{ route('blog.details',slug($item->slug)) }}">
                                            {{ $item->details?->title }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            {{ $blogs->appends($_GET)->links(template().'partials.pagination') }}
        </div>
    </section>
@endsection

