<div class="mt-50">
    <div class="row g-4 g-xl-5">
        <div class="col-lg-8">
            <div class="cmn-tabs">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-DESCRIPTION-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-DESCRIPTION" type="button" role="tab"
                                aria-controls="pills-DESCRIPTION" aria-selected="true">
                            <i class="fa-regular fa-file-lines"></i>
                            @lang('Description')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Guide-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-Guide" type="button" role="tab"
                                aria-controls="pills-Guide" aria-selected="false">
                            <i class="fa-regular fa-circle-info"></i>
                            @lang('Guide')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Reviews-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-Reviews" type="button" role="tab"
                                aria-controls="pills-Reviews" aria-selected="false">
                            <i class="fa-regular fa-star-sharp"></i>
                            @lang('Reviews')
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-DESCRIPTION" role="tabpanel"
                         aria-labelledby="pills-DESCRIPTION-tab" tabindex="0">
                        <div class="card">
                            <div class="card-body">
                                <h5>@lang('Description')</h5>
                                {!! $card->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-Guide" role="tabpanel"
                         aria-labelledby="pills-Guide-tab" tabindex="0">
                        <div class="card">
                            <div class="card-body">
                                <h5>@lang('Guide')</h5>
                                {!! $card->guide !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-Reviews" role="tabpanel"
                         aria-labelledby="pills-Reviews-tab" tabindex="0">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                    <div>
                                        <h6>@lang('Users reviews who have purchase')</h6>
                                        <div class="d-flex gap-4 mt-10">
                                            <p class="mb-0 d-flex align-items-center gap-2">@lang('Total Reviews')<span class="highlight fs-5">{{ formatNumber($card->total_review) }}</span> </p>
                                            <p class="mb-0 d-flex align-items-center gap-2">@lang('AVG Ratings')<span
                                                    class="highlight fs-5">{{ number_format($card->avg_rating) }}</span> </p>
                                        </div>
                                    </div>
                                    @if(count($reviewStatic['reviews']) > 0)
                                        <a href="{{route('reviewList').'?type=card&id='.$card->id}}" class="d-flex gap-1">@lang('All Reviews') <i
                                            class="fa-regular fa-circle-arrow-right"></i></a>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                @if(!empty($reviewStatic['reviews']))
                                    @foreach($reviewStatic['reviews'] as $review)
                                        <div class="review-item mb-20">
                                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-15">
                                                <div class="author-profile">
                                                    <a href="" class="img-box"><img
                                                            src="{{getFile($review->user?->image_driver,$review->user?->image)}}"
                                                            alt="image"></a>
                                                    <div class="text-box">
                                                        <h6 class="mb-0">{{$review->user?->fullname}}</h6>
                                                        <small>{{dateTime($review->created_at)}}</small>
                                                    </div>
                                                </div>
                                                <ul class="reviews d-flex align-items-center gap-3">
                                                    <li>
                                                        @php($maxLimit = 5)
                                                        @for($i=0;$i<$maxLimit;$i++)
                                                            @if($i < $review->rating)
                                                                <i class="active fa-solid fa-star"></i>
                                                            @else
                                                                <i class="fa-solid fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </li>
                                                </ul>
                                            </div>
                                            <p class="mb-0">{{$review->comment}}</p>
                                        </div>
                                    @endforeach
                                @endif

                                @if(auth()->check() && $reviewStatic['hasAlreadyOrdered'])
                                    <div class="review-box mt-30">
                                        <form action="{{route('card.user.addReview')}}" method="POST">
                                            @csrf
                                            <h4>@lang('Review this product')
                                            </h4>
                                            <input type="hidden" name="cardId" value="{{$card->id}}">
                                            <div class="ratings">
                                                <input type="radio" id="star1" name="rating" value="5">
                                                <label for="star1" title="text"></label>
                                                <input type="radio" id="star2" name="rating" value="4">
                                                <label for="star2" title="text"></label>
                                                <input checked type="radio" id="star3" name="rating" value="3">
                                                <label for="star3" title="text"></label>
                                                <input type="radio" id="star4" name="rating" value="2">
                                                <label for="star4" title="text"></label>
                                                <input type="radio" id="star5" name="rating" value="1">
                                                <label for="star5" title="text"></label>
                                            </div>
                                            <textarea class="form-control mt-20" name="comment"
                                                      id="exampleFormControlTextarea1"
                                                      placeholder="@lang('What was your experience?')"
                                                      onkeyup="countChar(this)" rows="5"
                                                      required></textarea>
                                            <div class="text-end"><span
                                                    id="charNum">200</span> @lang('Characters remaining')
                                            </div>
                                            @error('comment')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            <button class="cmn-btn mt-20" type="submit"><span>@lang('submit
                                                        review')</span></button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include(template().'frontend.card.related')
    </div>
</div>
@push('script')
    <script>
        'use strict';

        function countChar(val) {
            var len = val.value.length;
            if (len >= 500) {
                val.value = val.value.substring(0, 200);
            } else {
                $('#charNum').text(200 - len);
            }
        }
    </script>
@endpush
