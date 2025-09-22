@extends(template() . 'layouts.app')
@section('title',trans('Direct Topups'))
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
                                        <a href="{{ route('top-up', ['category' => $cat->id]) }}" class="category-link">
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
                            <h6>{{ str_pad($topUp->count(), 2, '0', STR_PAD_LEFT) }} @lang('Items found')</h6>
                        </div>
                        <div class="col-auto">
                            <form method="get" action="{{ route('top-up') }}" class="cardSearch">
                                <div class="d-flex align-items-center gap-2">
                                    <span>@lang('Sort By')</span>
                                    <div class="nice-select-section">
                                        <select class="nice-select right" name="filter" id="filterOption" onchange="this.form.submit()">
                                            <option value="all" data-display="All Type">@lang('All Type')</option>
                                            <option value="1" {{ (request()->filter == '1') ? 'selected' :'' }}>@lang('Top Rated')</option>
                                            <option value="2" {{ (request()->filter == '2') ? 'selected' :'' }}>@lang('Latest')</option>
                                            <option value="3" {{ (request()->filter == '3') ? 'selected' :'' }}>@lang('Date')</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="row g-3 g-sm-4">
                            @forelse($topUp as $item)
                                <div class="col-xl-3 col-md-4 col-6">
                                    <div class="category-box">
                                        <a href="{{ $item->top_up_detail_route }}" class="img-box">
                                            <img src="{{ $item->preview_image }}" alt="{{ $item->name }}" />
                                        </a>
                                        <div class="text-box">
                                            <a href="{{ $item->top_up_detail_route }}" class="title">{{ $item->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('empty')
                            @endforelse
                            {{ $topUp->appends(request()->query())->links(template().'partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
