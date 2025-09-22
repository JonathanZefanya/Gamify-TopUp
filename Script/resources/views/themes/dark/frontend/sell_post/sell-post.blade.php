@extends(template() . 'layouts.app')
@section('title', trans('Shop Now'))

@section('content')
    <section class="products-section">
        <div class="container">
            <div class="row g-4 g-xxl-5">
                <div class="col-lg-4">
                    <div class="d-none d-lg-block">
                        <form action="{{route('buy')}}" method="get">
                            <div class="sidebar-widget-area">
                                <h5 class="widget-title">@lang('Search')</h5>
                                <div class="search-box">
                                    <input type="text" class="form-control" name="search" placeholder="Search here..."
                                           value="{{old('search',request()->search)}}">
                                    <button type="submit" class="search-btn"><i class="far fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <form id="filterForm" action="{{route('buy')}}" method="get">
                            <div class="sidebar-widget-area">
                                <h5 class="widget-title">@lang('Filter by price')</h5>
                                <div class="range-area">
                                    <input type="text" class="js-range-slider priceRange" name="my_range"
                                           value="{{ request('my_range', $min.';'.$max) }}">
                                </div>
                            </div>
                            @if(isset($category) && $category->count() > 0)
                                <div class="sidebar-widget-area">
                                    <h5 class="widget-title">@lang('Categories')</h5>
                                    <div class="checkbox-categories-area">
                                        <div class="section-inner">
                                            <div class="categories-list">
                                                @foreach($category as $key => $cat)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="category[]"
                                                               value="{{ slug(optional($cat->details)->name) }}"
                                                               id="flexCheckChecked{{ $key }}"
                                                            {{ in_array(slug(optional($cat->details)->name), (array) request('category')) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexCheckChecked{{ $key }}">
                                                            <span>{{ optional($cat->details)->name }}</span>
                                                            <span class="">({{ $cat->active_post_count }})</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="mobile-filter-bar d-lg-none">
                        <button class="cmn-btn mb-10" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                            <i class="fa-regular fa-filter-list"></i>
                            @lang('Filters')
                        </button>
                    </div>
                    <div class="row justify-content-between align-items-center gap-2">
                        <div class="col-auto">
                            <h6>{{ str_pad($sellPost->total(), 2, '0', STR_PAD_LEFT) }}@lang(' Items found')</h6>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-2">
                                <span>@lang('Sort By')</span>
                                <form id="sortForm" action="{{ route('buy') }}" method="get">
                                    <div class="nice-select-section">
                                        <select class="nice-select right" name="sort" id="sortSelect">
                                            <option value="all"
                                                    data-display="All Type" {{ request()->sort == 'all' ? 'selected' : '' }}>
                                                @lang('All Type')
                                            </option>
                                            <option value="ltoh" {{ request()->sort == 'ltoh' ? 'selected' : '' }}>
                                                @lang('Price') <sub>@lang('(Low To High)')</sub>
                                            </option>
                                            <option value="htol" {{ request()->sort == 'htol' ? 'selected' : '' }}>
                                                @lang('Price') <sub>@lang('(High To Low)')</sub>
                                            </option>
                                        </select>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="row g-4">
                            @forelse($sellPost as $key => $item)
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="product-box3">
                                        <div class="img-box owl-carousel owl-theme img-carousel">
                                            @foreach($item->image as $key => $img)
                                                <div class="item">
                                                    <img src="{{ getFile($item->image_driver, $img) }}"
                                                         alt="{{ 'Image '.$key+1 }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="text-box">
                                            <a class="title"
                                               href="{{ route('sellPost.details',[slug($item->title), $item->id]) }}">{{ $item->title ?? '' }}</a>
                                            <div class="d-flex justify-content-between">
                                                <div class="price">@lang('Price: ')
                                                    <span>{{ userCurrencyPosition($item->price) }}</span></div>
                                                <div class="d-flex justify-content-between gap-3 mt-2">
                                                    <small>
                                                        <p
                                                            class="cursor-pointer"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-html="true"
                                                            title="
                                                           @foreach($item->post_specification_form as $index => $extra)
                                                               @if($index >= 2)
                                                                   {{ formatFieldName($extra->field_name) }} : {{ $extra->field_value }}<br>
                                                               @endif
                                                           @endforeach
                                                           ">
                                                            <i class="fa-regular fa-hand-pointer ps-1 text-warning miniIco"></i>
                                                        </p>
                                                    </small>
                                                </div>
                                            </div>
                                            <hr class="cmn-hr3">
                                            <a class="make-offer-btn makeOffer" data-resource="{{ $item->id }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#makeOffer">@lang('make offer') <i
                                                    class="fa-regular fa-circle-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('empty')
                            @endforelse
                            {{ $sellPost->appends(request()->query())->links(template().'partials.pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Modal for Make Offer -->
    <div class="modal fade" id="makeOffer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-custom">
                    <h4 class="modal-title" id="myModalLabel">@lang('Make Offer')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <form action="{{route('user.sellPostOffer')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="customize-modal">
                            <input type="hidden" class="sell_post_id" name="sell_post_id" value="">
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold"> @lang('Amount') </label>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" name="amount" class="form-control earn" required/>
                                        <button class="cmn-btn copy-btn"
                                                type="button">{{basicControl()->base_currency}}</button>
                                    </div>
                                    @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label for="description" class="font-weight-bold"> @lang('Description') </label>
                                    <textarea name="description" rows="2" class="form-control custom earn" value=""
                                              required></textarea>
                                </div>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="cmn-btn sellPostOfferButton" id="sellPostOfferButton">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .make-offer-btn {
            cursor: pointer;
        }
    </style>
@endpush
@push('script')

    <script>
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    document.getElementById('filterForm').submit();
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        $(document).ready(function () {
            let delayTimer;
            $(".js-range-slider").ionRangeSlider({
                type: "double",
                min: {{ (int) $rangeMin }},
                max: {{ (int) $rangeMax }},
                from: {{ (int) ($min ?? $rangeMin) }},
                to: {{ (int) ($max ?? $rangeMax) }},
                grid: false,
                onFinish: function (data) {
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(() => {
                        document.getElementById('filterForm').submit();
                    }, 1000);
                }
            });
            $('#sortSelect').on('change', function () {
                console.log('Here');
                $('#sortForm').submit();
            });

            $('.makeOffer').on('click', function () {
                let sellPostUser = $(this).data('user_id');
                let authUserId = @json(auth()->id());

                $('.sell_post_id').val($(this).data('resource'));

                if (authUserId === sellPostUser) {
                    $('#sellPostOfferButton').prop('disabled', true);
                    $('#sellPostOfferButton').attr('title', 'You cannot offer on your own post').tooltip('show');
                } else {
                    $('#sellPostOfferButton').prop('disabled', false);
                    $('#sellPostOfferButton').tooltip('dispose');
                    $('#sellPostOfferButton').removeAttr('title');
                }
            })
        })

    </script>

@endpush
