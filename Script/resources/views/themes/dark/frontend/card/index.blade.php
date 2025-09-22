@extends(template() . 'layouts.app')
@section('title',trans('Cards'))
@section('content')
    <section class="products-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="sidebar-widget-area">
                        <h4 class="widget-title">@lang('Categories')</h4>
                        <div class="checkbox-categories-area">
                            <div class="section-inner">
                                <div class="categories-list">
                                    @foreach($categories as $cat)
                                        <a href="{{ route('cards', ['category' => $cat->id]) }}" class="category-link">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="{{ $cat->icon }}"></i>
                                                {{ $cat->name }}
                                            </div>
                                            <span>{{ $cat->active_children }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row justify-content-between align-items-center gap-2">
                        <div class="col-auto">
                            <h6>{{ str_pad($cards->count(), 2, '0', STR_PAD_LEFT) }} @lang('Items found')</h6>
                        </div>
                        <div class="col-auto">
                            <form method="get" action="{{ route('cards') }}" class="cardSearch">
                                <div class="d-flex align-items-center gap-2">
                                    <span>@lang('Sort By')</span>
                                    <div class="nice-select-section">
                                        <select class="nice-select right" name="filter" id="filterOption" onchange="this.form.submit()">
                                            <option value="all" data-display="All Type">@lang('All Type')</option>
                                            <option value="1" {{ (request()->filter == '1') ? 'selected' : '' }}>@lang('Popular')</option>
                                            <option value="2" {{ (request()->filter == '2') ? 'selected' : '' }}>@lang('Latest')</option>
                                            <option value="3" {{ (request()->filter == '3') ? 'selected' : '' }}>@lang('Trending')</option>
                                            <option value="4" {{ (request()->filter == '4') ? 'selected' : '' }}>@lang('Date')</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="row g-3 g-sm-4">
                            @forelse($cards as $item)
                                <div class="col-md-6">
                                    <a href="{{ $item->card_detail_route }}" class="product-box">
                                        <div class="img-box">
                                            <img src="{{ $item->preview_image }}" alt="{{ $item->name ?? ' ' }}" />
                                        </div>
                                        <div class="text-box">
                                            <div class="top-info">
                                                <div class="review">
                                                    <div class="reviews d-flex align-items-center gap-2">
                                                        <div>
                                                            {!! displayStarRating(@$item->avg_rating) !!}
                                                        </div>
                                                        <span>{{ $item->total_review }}(@lang('reviews'))</span>
                                                    </div>
                                                </div>
                                                <div class="title mt-10">
                                                    {{ $item->name ?? ' ' }}
                                                </div>
                                                <p class="name mt-1">{{ $item->region }}</p>
                                            </div>
                                            <div class="bottom-info">
                                                <div class="price">
                                                    </div>
                                                <div class="promo-price">
                                                    <div>
                                                        @lang('Starting-') <span class="number">{{ userCurrencyPosition($item->serviceWithLowestPrice()->price) }}</span>
                                                    </div>
                                                    <div class="sell">
                                                        <i class="fa-regular fa-shopping-cart pe-1"></i>{{ formatNumber($item->sell_count) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                @include('empty')
                            @endforelse
                            {{ $cards->appends(request()->query())->links(template().'partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style>
        .promo-price{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
@endpush
