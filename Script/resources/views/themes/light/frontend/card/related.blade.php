<div class="sidebar-widget-area">
    <div class="cmn-tabs">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-Related-Cards-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-Related-Cards" type="button" role="tab"
                        aria-controls="pills-Related-Cards" aria-selected="true">
                    @lang('Related Cards')</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-Others-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-Others" type="button" role="tab"
                        aria-controls="pills-Others" aria-selected="false">
                    @lang('Others')</button>
            </li>

        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-Related-Cards" role="tabpanel"
                 aria-labelledby="pills-Related-Cards-tab" tabindex="0">
                <div class="row g-4">
                    @if(!empty($relatedCards))
                        @foreach($relatedCards as $relatedCard)
                            <div class="col-lg-12 col-sm-6">
                                <a href="{{route('card.details',$relatedCard->slug)}}" class="related-card">
                                    <div class="img-box">
                                        <img
                                            src="{{getFile($relatedCard->image->preview_driver,$relatedCard->image->preview)}}"
                                            alt="{{$relatedCard->name}}">
                                    </div>
                                    <div class="text-box">
                                        <h6>{{$relatedCard->name}}</h6>
                                        <p class="mb-0">{{$relatedCard->region}}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="pills-Others" role="tabpanel"
                 aria-labelledby="pills-Others-tab" tabindex="0">
                <div class="row g-4">
                    @if(!empty($otherCards))
                        @foreach($otherCards as $otherCard)
                            <div class="col-lg-12 col-sm-6">
                                <a href="{{route('card.details',$otherCard->slug)}}" class="related-card">
                                    <div class="img-box">
                                        <img
                                            src="{{getFile($otherCard->image->preview_driver,$otherCard->image->preview)}}"
                                            alt="{{$otherCard->name}}">
                                    </div>
                                    <div class="text-box">
                                        <h6>{{$otherCard->name}}</h6>
                                        <p class="mb-0">{{$otherCard->region}}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('style')
    <style>
        .nav-item .nav-link.active{
            color: #fff !important;
        }
    </style>

@endpush
