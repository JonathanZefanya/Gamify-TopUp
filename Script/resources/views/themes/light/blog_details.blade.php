@extends(template() . 'layouts.app')
@section('title',trans('Blog Details'))
@section('content')
    <section class="blog-details-section">
        <div class="container">
            <div class="row g-4 g-sm-5">
                <div class="col-lg-7">
                    <div class="blog-box-large">
                        <div class="thumbs-area">
                            <img src="{{ getFile($blogDetails->blog?->banner_image_driver,$blogDetails->blog?->banner_image) }}" alt="{{ $blogDetails->title }}">
                        </div>
                        <div class="content-area mt-20">
                            <ul class="meta mb-15">
                                <li class="item">
                                    <span class="icon"><i class="fa-light fa-calendar-days"></i></span>
                                    <span>{{dateTime($blogDetails->created_at,'d M y')}}</span>
                                </li>
                                <li class="item">
                                    {{ $blogDetails->category?->name }}
                                </li>
                            </ul>
                            <h3 class="blog-title">{{ $blogDetails->title }}</h3>

                            <div class="para-text">
                                {!! $blogDetails->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="social-share-box">
                        <h4 class="title">@lang('social share :')</h4>
                        <div id="shareBlock"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="blog-sidebar">
                        <form action="{{route('blog')}}" method="get">
                            <div class="sidebar-widget-area">
                                <h4 class="widget-title">Search</h4>
                                <div class="search-box">
                                    <input type="text" class="form-control" name="search" value="{{ @request()->title }}" placeholder="Search here...">
                                    <button type="submit" class="search-btn"><i class="far fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="sidebar-widget-area">
                            <div class="sidebar-categories-area">
                                <div class="categories-header">
                                    <h4 class="widget-title">@lang('Categories')</h4>
                                </div>
                                <ul class="categories-list">
                                    @if(!empty($categories))
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{route('blog', $category->slug)}}"><span>{{$category->name}}</span> <span class="highlight">({{$category->blogs_count}})</span></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget-area">
                            <h4 class="widget-title">@lang('Recent Post')</h4>
                            @if(isset($popularContentDetails))
                                @foreach($popularContentDetails as $popular)
                                    <a href="{{route('blog.details', optional($popular->blog)->slug)}}" class="sidebar-widget-item">
                                        <div class="img-area">
                                            <img src="{{ getFile(optional($popular->blog)->blog_image_driver, optional($popular->blog)->blog_image) }}" alt="@lang($popular->title)">
                                        </div>
                                        <div class="content-area">
                                            <div class="title">@lang($popular->title)</div>
                                            <div class="widget-date">
                                                <i class="fa-regular fa-calendar-days"></i>{{dateTime($popular->created_at,'d M y')}}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js-lib')
    <script src="{{ asset(template(true) . 'js/socialSharing.js') }}"></script>
@endpush
@push('extra_scripts')
    <script>
        'use strict';

        if ($("#shareBlock").length) {
            $("#shareBlock").socialSharingPlugin({
                urlShare: window.location.href,
                description: $("meta[name=description]").attr("content"),
                title: $("title").text(),
            });
        }
    </script>
@endpush
