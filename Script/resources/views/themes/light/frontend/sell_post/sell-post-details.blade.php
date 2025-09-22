@extends(template() . 'layouts.app')
@section('title', trans('Post Details'))

@section('content')
    <section class="sell-post-details-section">
        <div class="container">
            <div class="row g-4 g-xxl-5">
                <div class="col-lg-7">
                    <div class="product-box3">
                        <div class="img-box owl-carousel owl-theme img-carousel">
                            @for($i = 0; $i<count($sellPost->image); $i++)
                                <div class="item">
                                    <img src="{{ getFile($sellPost->image_driver,@$sellPost->image[$i]) }}" alt="@lang('Post Image '.$i)">
                                </div>
                            @endfor
                        </div>
                        <div class="text-box">
                            <div class="title" href="">{{ $sellPost->title }}</div>
                            <div class="price">@lang('Price:') <span>{{ userCurrencyPosition($price) }}</span></div>
                            @if($sellPost->payment_status == 1)
                                <span class="badge text-bg-success">@lang('Payment Completed')</span>
                            @else
                                @if($sellPost->payment_lock == 1)
                                    @if(Auth::check() && Auth::id()==$sellPost->lock_for)
                                        <span class="badge text-bg-secondary">@lang('Waiting Payment')</span>
                                    @elseif(Auth::check() &&  Auth::id()==$sellPost->user_id)
                                        <span class="badge text-bg-dark">@lang('Payment Processing')</span>
                                    @else
                                        <span class="badge text-bg-warning">@lang('Going to Sell')</span>
                                    @endif
                                @endif
                            @endif

                            @if($sellPost->post_specification_form)
                                <div class="d-flex justify-content-between gap-3 mt-2">
                                    @forelse($sellPost->post_specification_form as $k => $v)
                                    <span>{{formatFieldName($v->field_name)}} : {{$v->field_value}}</span>
                                    @empty
                                    @endforelse
                                </div>
                            @endif
                        </div>

                        @if($sellPost->payment_status != '1')
                            @if(Auth::check() &&  $sellPost->user_id != Auth::id())
                                <div class="buyBtn">
                                    <button type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#paymentConfirm"
                                            class="game-btn-sm cmn-btn"><i
                                            class="fa fa-shopping-cart"></i> @lang('Buy')</button>
                                </div>

                            @endif
                        @endif
                    </div>
                    <p class="mt-10 mb-0 p-3">{{ $sellPost->details }}</p>
                </div>

                @if(Auth::check() &&  $sellPost->user_id == Auth::id())
                    <div class="col-md-5">
                        <div class="custom-card">
                            <div class="contact-box ">
                                <div class="offer-maker-list light-offer-maker-list">
                                    <div class="sellpost-offer-box d-flex justify-content-between mb-1">
                                        <h6>@lang('Offer History')</h6>
                                        <a href="{{route('user.sellPostOfferMore')."?postId=".$sellPost->id}}">
                                            <button class="game-btn-sm cmn-btn" id="btnSellAll">
                                                @lang('More')<img
                                                    src="{{asset(template(true).'/img/arrow-white.png')}}"
                                                    alt="...">
                                            </button>
                                        </a>
                                    </div>
                                    @forelse($sellPostOffer as $k => $row)
                                        <div class="sellpost-offer-box d-flex">
                                            <div class="flex-shrink-0">
                                                <a href="javascript:void(0)"
                                                   title="{{optional($row->user)->username}}">
                                                    <img src="{{ getFile(auth()->user()->image_driver, auth()->user()->image) }}" class="rounded-circle"
                                                         width="35" height="35" alt="Sample Image">
                                                </a>
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6>{{optional($row->user)->fullname}}</h6>

                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <div class="btn-group" role="group">
                                                            <button id="offerActionBtn" type="button"
                                                                    class="btn text-white dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>

                                                            <ul class="dropdown-menu" aria-labelledby="offerActionBtn">

                                                                @if($row->status != 1)
                                                                    <li><a class="dropdown-item offerAccept"
                                                                           href="javascript:void(0)"
                                                                           data-resource="{{$row->id}}"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#offerAccept"><i
                                                                                class="text-success fa fa-check-circle"></i> @lang('Accept')
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li><a class="dropdown-item"
                                                                           href="{{route('user.offerChat',$row->uuid)}}"><i
                                                                                class="text-success fa fa-comment"></i> @lang('Conversation')
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if($row->status == 0 || $row->status == 3)
                                                                    <li><a class="dropdown-item offerReject"
                                                                           href="javascript:void(0)"
                                                                           data-resource="{{$row->id}}"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#offerReject"><i
                                                                                class="text-danger fa fa-times"></i> @lang('Reject')
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if($row->status == 2 || $row->status == 0 || $row->status == 3)
                                                                    <li><a class="dropdown-item offerRemove"
                                                                           href="javascript:void(0)"
                                                                           data-resource="{{$row->id}}"
                                                                           data-bs-toggle="modal"
                                                                           data-bs-target="#offerRemove"><i
                                                                                class="text-danger fa fa-trash-alt"></i> @lang('Remove')
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                                <span class="d-block base-color">{{basicControl()->currency_symbol}}{{getAmount($row->amount)}}</span>
                                                <div class="d-flex ">

                                                    @if($sellPost->payment_lock == 1 && $sellPost->lock_for == $row->user_id && $sellPost->payment_status ==0)
                                                        <span
                                                            class="badge text-bg-warning">@lang('Payment Processing')</span>

                                                    @elseif($sellPost->payment_lock == 1 && $sellPost->lock_for == $row->user_id && $sellPost->payment_status ==1)
                                                        <span class="badge text-bg-success">@lang('Payment Complete')</span>

                                                    @else

                                                        @if($row->status == 0)
                                                            <span class="badge text-bg-warning">@lang('Pending')</span>
                                                        @elseif($row->status ==1)
                                                            <span class="badge text-bg-success">@lang('Accepted')</span>
                                                        @elseif($row->status ==2)
                                                            <span class="badge text-bg-danger">@lang('Rejected')</span>
                                                        @elseif($row->status ==3)
                                                            <span class="badge text-bg-info">@lang('Resubmission')</span>
                                                        @endif
                                                    @endif

                                                    <small class="ms-3"><i
                                                            class="fa fa-clock"></i> {{diffForHumans($row->created_at)}}
                                                    </small>
                                                </div>

                                                <p class="mt-3">@lang($row->description)</p>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @if($sellPost->payment_lock == 0 && $sellPost->payment_status !=1)
                        <div class="col-lg-5">
                            <form action="{{route('user.sellPostOffer')}}" method="POST">
                                @csrf
                                <div class="sidebar-widget-area">
                                    <h4 class="widget-title">@lang('Make a Offer')</h4>
                                    <input type="hidden" name="sell_post_id" value="{{$sellPost->id}}">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label" for="Amount">@lang('Amount')</label>
                                            <input type="number" class="form-control" id="Amount" placeholder="Enter Amount" name="amount" required>

                                            @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="Description">@lang('Description')</label>
                                            <textarea name="description" class="form-control custom"
                                                       id="Description" rows="5"required></textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="kew-btn">
                                                <span class="kew-text">@lang('Make Offer')</span>
                                                <div class="kew-arrow">
                                                    <div class="kt-one"><i class="fa-regular fa-arrow-right-long"></i></div>
                                                    <div class="kt-two"><i class="fa-regular fa-arrow-right-long"></i></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <!-- Offer Accept Model -->
    <div class="modal fade" id="offerAccept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-custom">
                    <h4 class="modal-title" id="myModalLabel">@lang('Accept Offer')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{route('user.sellPostOfferAccept')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="acceptOfferId" name="offer_id" value="">
                        <label>@lang('Say Something')</label>
                        <textarea name="description" rows="4" class="form-control custom earn mt-3"
                                  required></textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="cmn-btn">@lang('Submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Offer Remove Model -->
    <div class="modal fade" id="offerRemove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-custom">
                    <h4 class="modal-title" id="myModalLabel">@lang('Remove Offer')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{route('user.sellPostOfferRemove')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="removeOfferId" name="offer_id" value="">
                        <label>@lang('Are you want to remove this offer ?')</label>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="cmn-btn">@lang('Yes')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Offer Reject Model -->
    <div class="modal fade" id="offerReject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-custom">
                    <h4 class="modal-title" id="myModalLabel">@lang('Reject Offer')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{route('user.sellPostOfferReject')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="rejectOfferId" name="offer_id" value="">
                        <label>@lang('Are you want to reject this offer ?')</label>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="cmn-btn">@lang('Yes')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Offer Accept Model -->
    <div class="modal fade" id="paymentConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-custom">
                    <h4 class="modal-title" id="myModalLabel">@lang('Confirmation')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{route('user.sellPost.payment',$sellPost)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you confirm to payment now ?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="cmn-btn">@lang('Submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .product-box3 {
            position: relative;
        }

        .buyBtn {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        @media (max-width: 768px) {
            .buyBtn {
                top: 196px;
                right: 10px;
            }
        }

    </style>
@endpush

@push('script')
    <script>
        'use strict';

        $(document).ready(function () {
            $('.offerRemove').on('click', function () {
                $('.removeOfferId').val($(this).data('resource'));
            })
        })

        $(document).ready(function () {
            $('.offerReject').on('click', function () {
                $('.rejectOfferId').val($(this).data('resource'));
            })
        })

        $(document).ready(function () {
            $('.offerAccept').on('click', function () {
                $('.acceptOfferId').val($(this).data('resource'));
            })
        })
    </script>
@endpush
