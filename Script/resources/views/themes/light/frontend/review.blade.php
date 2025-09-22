@extends(template() . 'layouts.app')
@section('title',trans('Reviews'))
@section('content')
    <section class="reviews-details-section">
        <div class="container">
            <div class="row g-4 g-xxl-5">
                <div class="col-lg-4">
                    <div class="sidebar-card-box">
                        <div class="header-box">
                            <div class="img-box">
                                <img src="{{getFile(@$game->image->preview_driver,@$game->image->preview)}}"
                                     alt="{{$game->name}}">
                            </div>
                            <div class="text-box">
                                <h5>{{$game->name}}</h5>
                                <p>{{$game->region}}</p>
                            </div>
                        </div>
                        <div class="reviews-rating-box">
                            <div class="item">
                                <h3>{{number_format($game->total_review)}}</h3>
                                <p>@lang('Total Reviews')</p>
                            </div>
                            <div class="item">
                                <h3>{{number_format($game->avg_rating)}}</h3>
                                <p>@lang('Avg Rating')</p>
                            </div>
                        </div>

                        <div class="progress-box mt-20">
                            <div class="progress-item">
                                <h6>@lang('Excellent')</h6>
                                <div class="progress">
                                    <div class="progress-bar"
                                         data-progress="{{($reviewStatic['excellentCount'] * 100) /$game->total_review}}"></div>
                                </div>
                                <span>{{$reviewStatic['excellentCount']}}</span>
                            </div>
                            <div class="progress-item">
                                <h6>@lang('Great')</h6>
                                <div class="progress">
                                    <div class="progress-bar"
                                         data-progress="{{($reviewStatic['greatCount'] * 100) /$game->total_review}}"></div>
                                </div>
                                <span>{{$reviewStatic['greatCount']}}</span>
                            </div>
                            <div class="progress-item">
                                <h6>@lang('Average')</h6>
                                <div class="progress">
                                    <div class="progress-bar"
                                         data-progress="{{($reviewStatic['averageCount'] * 100) /$game->total_review}}"></div>
                                </div>
                                <span>{{$reviewStatic['averageCount']}}</span>
                            </div>
                            <div class="progress-item">
                                <h6>@lang('Poor')</h6>
                                <div class="progress">
                                    <div class="progress-bar"
                                         data-progress="{{($reviewStatic['poorCount'] * 100) /$game->total_review}}"></div>
                                </div>
                                <span>{{$reviewStatic['poorCount']}}</span>
                            </div>
                            <div class="progress-item">
                                <h6>@lang('Bad')</h6>
                                <div class="progress">
                                    <div class="progress-bar"
                                         data-progress="{{($reviewStatic['badCount'] * 100) /$game->total_review}}"></div>
                                </div>
                                <span>{{$reviewStatic['badCount']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h4>@lang('Reviews About') `{{$game->name}}` </h4>
                    <div class="button-group isotope-btn-group mt-20">
                        <button class="active" data-filter=".all">@lang('All')</button>
                        <button data-filter=".excellent">@lang('Excellent')</button>
                        <button data-filter=".great">@lang('Great')</button>
                        <button data-filter=".average">@lang('Average')</button>
                        <button data-filter=".poor">@lang('Poor')</button>
                        <button data-filter=".bad">@lang('Bad')</button>
                    </div>

                    <div class="isotop-content">
                        <div class="listing-row">
                            @if(!empty($reviewStatic['excellentReview']))
                                @forelse($reviewStatic['excellentReview'] as $excellent)
                                    <div class="reviews-single grid-item excellent all">
                                        <div class="left-side">
                                            <div class="img-box">
                                                <img
                                                    src="{{getFile($excellent->user?->image_driver,$excellent->user?->image)}}"
                                                    alt="{{ $excellent->user?->fullname }}">
                                            </div>
                                            <div class="text-box">
                                                <div class="title">
                                                    <h6>{{$excellent->user?->fullname}} </h6>
                                                </div>
                                                <a href="mailto:{{$excellent->user?->email}}"
                                                   class="contact-item">{{$excellent->user?->email}}</a>
                                            </div>
                                        </div>

                                        <div class="right-side">
                                            <div class="main-content">
                                                <ul class="reviews d-flex align-items-center gap-2 flex-wrap mb-10">
                                                    {!! displayStarRating($excellent->rating) !!}
                                                </ul>
                                                <p>{{$excellent->comment}}</p>
                                            </div>
                                            <div class="date">
                                                {{dateTime($excellent->created_at)}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="reviews-single grid-item excellent">
                                        <div class="right-side">
                                            <div class="main-content">
                                                <h4>@lang('No Review Found')</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            @endif

                            @if(!empty($reviewStatic['greatReview']))
                                @forelse($reviewStatic['greatReview'] as $great)
                                    <div class="reviews-single grid-item great all">
                                        <div class="left-side">
                                            <div class="img-box">
                                                <img src="{{getFile($great->user?->image_driver,$great->user?->image)}}"
                                                     alt="{{ $great->user?->fullname }}">
                                            </div>
                                            <div class="text-box">
                                                <div class="title">
                                                    <h6>{{$great->user?->fullname}} </h6>
                                                </div>
                                                <a href="mailto:{{$great->user?->email}}"
                                                   class="contact-item">{{$great->user?->email}}</a>
                                            </div>
                                        </div>
                                        <div class="right-side">
                                            <div class="main-content">
                                                <ul class="reviews d-flex align-items-center gap-2 flex-wrap mb-10">
                                                    {!! displayStarRating($great->rating) !!}
                                                </ul>
                                                <p>{{$great->comment}}</p>
                                            </div>
                                            <div class="date">
                                                {{dateTime($excellent->created_at)}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="reviews-single grid-item great">
                                        <div class="right-side">
                                            <div class="main-content">
                                                <h4>@lang('No Review Found')</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            @endif

                            @if(!empty($reviewStatic['averageReview']))
                                @forelse($reviewStatic['averageReview'] as $average)
                                    <div class="reviews-single grid-item average all">
                                        <div class="left-side">
                                            <div class="img-box">
                                                <img src="{{getFile($average->user?->image_driver,$average->user?->image)}}"
                                                     alt="{{ $average->user?->fullname }}">
                                            </div>
                                            <div class="text-box">
                                                <div class="title">
                                                    <h6>{{$average->user?->fullname}} </h6>
                                                </div>
                                                <a href="mailto:{{$average->user?->email}}"
                                                   class="contact-item">{{$average->user?->email}}</a>
                                            </div>
                                        </div>
                                        <div class="right-side">
                                            <div class="main-content">
                                                <ul class="reviews d-flex align-items-center gap-2 flex-wrap mb-10">
                                                    {!! displayStarRating($average->rating) !!}
                                                </ul>
                                                <p>{{$average->comment}}</p>
                                            </div>
                                            <div class="date">
                                                {{dateTime($average->created_at)}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="reviews-single grid-item average">
                                        <div class="right-side">
                                            <div class="main-content">
                                                <h4>@lang('No Review Found')</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            @endif

                            @if(!empty($reviewStatic['poorReview']))
                                @forelse($reviewStatic['poorReview'] as $poor)
                                    <div class="reviews-single grid-item poor all">
                                        <div class="left-side">
                                            <div class="img-box">
                                                <img src="{{getFile($poor->user?->image_driver,$poor->user?->image)}}"
                                                     alt="{{ $poor->user?->fullname }}">
                                            </div>
                                            <div class="text-box">
                                                <div class="title">
                                                    <h6>{{$poor->user?->fullname}} </h6>
                                                </div>
                                                <a href="mailto:{{$poor->user?->email}}"
                                                   class="contact-item">{{$poor->user?->email}}</a>
                                            </div>
                                        </div>
                                        <div class="right-side">
                                            <div class="main-content">
                                                <ul class="reviews d-flex align-items-center gap-2 flex-wrap mb-10">
                                                    {!! displayStarRating($poor->rating) !!}
                                                </ul>
                                                <p>{{$poor->comment}}</p>
                                            </div>
                                            <div class="date">
                                                {{dateTime($poor->created_at)}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="reviews-single grid-item poor">
                                        <div class="right-side">
                                            <div class="main-content">
                                                <h4>@lang('No Review Found')</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            @endif

                            @if(!empty($reviewStatic['badReview']))
                                @forelse($reviewStatic['badReview'] as $bad)
                                    <div class="reviews-single grid-item bad all">
                                        <div class="left-side">
                                            <div class="img-box">
                                                <img src="{{getFile($bad->user?->image_driver,$bad->user?->image)}}"
                                                     alt="{{ $bad->user?->fullname }}">
                                            </div>
                                            <div class="text-box">
                                                <div class="title">
                                                    <h6>{{$bad->user?->fullname}} </h6>
                                                </div>
                                                <a href="mailto:{{$bad->user?->email}}"
                                                   class="contact-item">{{$bad->user?->email}}</a>
                                            </div>
                                        </div>
                                        <div class="right-side">
                                            <div class="main-content">
                                                <ul class="reviews d-flex align-items-center gap-2 flex-wrap mb-10">
                                                    {!! displayStarRating($bad->rating) !!}
                                                </ul>
                                                <p>{{$bad->comment}}</p>
                                            </div>
                                            <div class="date">
                                                {{dateTime($bad->created_at)}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="reviews-single grid-item bad">
                                        <div class="right-side">
                                            <div class="main-content">
                                                <h4>@lang('No Review Found')</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset(template(true) . 'js/isotope.js')}}"></script>
    <script>
        let $grid = $('.listing-row').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                columnWidth: 1
            }
        });

        let selectedFilter = localStorage.getItem('selectedFilter') || '.all';
        $grid.isotope({filter: selectedFilter});

        $('.isotope-btn-group button').removeClass('active');
        $('.isotope-btn-group button[data-filter="' + selectedFilter + '"]').addClass('active');

        $('.isotope-btn-group').on('click', 'button', function () {
            let filterValue = $(this).attr('data-filter');
            $grid.isotope({filter: filterValue});
            localStorage.setItem('selectedFilter', filterValue);

            $(this).siblings('.active').removeClass('active');
            $(this).addClass('active');
        });

        $grid.isotope('layout');

        $('.form-check-input').on('change', function () {
            $('.review-single-hidden-box').toggle(this.checked);
            $grid.isotope('layout');
        });

        // Isotope ends

        //--- BAR FILLER ---//
        if ($(".progress-bar").length) {
            const progressItem = document.getElementsByClassName("progress-item")[0];
            const progressBars = document.querySelectorAll('.progress-bar');

            function showProgress() {
                progressBars.forEach(progressBar => {
                    const value = progressBar.dataset.progress;
                    progressBar.style.opacity = 1;
                    progressBar.style.width = `${value}%`;
                });
            }

            function hideProgress() {
                progressBars.forEach(p => {
                    p.style.opacity = 0;
                    p.style.width = 0;
                });
            }

            window.addEventListener('scroll', () => {
                const sectionPos = progressItem.getBoundingClientRect().top;
                const screenPos = window.innerHeight;
                if (sectionPos < screenPos) {
                    showProgress();
                } else {
                    hideProgress();
                }
            });
        }
    </script>
@endpush
