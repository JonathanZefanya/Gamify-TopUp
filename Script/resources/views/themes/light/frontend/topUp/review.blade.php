<div class="card mt-25">
    <div class="card-header">
        <h5 class="mb-0">@lang('Description')</h5>
    </div>
    <div class="card-body">
        {!! $topUp->description !!}
    </div>
</div>
<div class="card mt-25">
    <div class="card-header">
        <h5 class="mb-0">@lang('Guide')</h5>
    </div>
    <div class="card-body">
        {!! $topUp->guide !!}
    </div>
</div>

<div class="card mt-25">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <h6>@lang('Users reviews who have purchase')</h6>
                <div class="d-flex gap-4 mt-10">
                    <p class="mb-0 d-flex align-items-center gap-2">@lang('Total Reviews')<span class="highlight fs-5">{{ formatNumber($topUp->total_review) }}</span> </p>
                    <p class="mb-0 d-flex align-items-center gap-2">@lang('AVG Ratings')<span
                            class="highlight fs-5">{{ number_format($topUp->avg_rating) }}</span> </p>
                </div>
            </div>
            @if(count($reviewStatic['reviews']) > 0)
                <a href="{{route('reviewList').'?type=topup&id='.$topUp->id}}" class="d-flex gap-1">@lang('All Reviews') <i
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
                        <div class="reviews d-flex align-items-center gap-3">
                            <div>
                                {!! displayStarRating($review->rating) !!}
                            </div>
                        </div>
                    </div>
                    <p class="mb-0">{{$review->comment}}</p>
                </div>
            @endforeach
        @endif
        @if(auth()->check() && $reviewStatic['hasAlreadyOrdered'])
            <div class="review-box mt-30">
                <form action="{{route('topUp.user.addReview')}}" method="POST">
                    @csrf
                    <h4>@lang('Review this product')
                    </h4>
                    <input type="hidden" name="cardId" value="{{$topUp->id}}">
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
                    <button class="cmn-btn mt-20" type="submit"><span>@lang('submit review')</span></button>
                </form>
            </div>
        @endif
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
