@extends(template() . 'layouts.user')
@section('title', trans('Offer List'))

@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Offer Post')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Offer Post')</li>
                </ol>
            </nav>
        </div>
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>@lang('Offer List')</h4>
                        <div class="btn-area d-flex align-items-center justify-content-end gap-1">
                            <form action="{{ route('user.sellPostOfferMore') }}" method="get" class="searchFormSortBy">
                                <input type="hidden" class="sortby_field" name="sortBy" value="">
                                <div class="btn-group btn-group-sm sortByBtn" role="group">
                                    <div class="btn-group" role="group">
                                        <button id="sortByActionBtn" type="button"
                                                class="cmn-btn2 dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            @lang('Sort By')
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="sortByActionBtn">
                                            <li>
                                                <a data-sortby="latest"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='latest') active @endif"
                                                   href="javascript:void(0)">@lang('Latest Offer')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="high_to_low"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='high_to_low') active @endif"
                                                   href="javascript:void(0)">@lang('Price high to low')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="low_to_high"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='low_to_high') active @endif"
                                                   href="javascript:void(0)">@lang('Price low to high')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="processing"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='processing') active @endif"
                                                   href="javascript:void(0)">@lang('Payment Processing')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="complete"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='complete') active @endif"
                                                   href="javascript:void(0)">@lang('Payment Completed')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="pending"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='pending') active @endif"
                                                   href="javascript:void(0)">@lang('Pending')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="rejected"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='rejected') active @endif"
                                                   href="javascript:void(0)">@lang('Rejected')
                                                </a>
                                            </li>
                                            <li>
                                                <a data-sortby="resubmission"
                                                   class="dropdown-item sortByAttempt @if(request()->sortBy =='resubmission') active @endif"
                                                   href="javascript:void(0)">@lang('Resubmission')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>

                            <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                                    class="fa-regular fa-filter"></i></button>

                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($sellPostOffer as $k => $row)
                            <div class="d-flex @if(optional($row->sellPost)->payment_lock == 1 && optional($row->sellPost)->lock_for == $row->user_id && \Carbon\Carbon::now() < Carbon\Carbon::parse(optional($row->sellPost)->lock_at)->addMinutes(basicControl()->payment_expired))
                                paid-making-payment
                                @endif">
                                <div class="flex-shrink-0 user">
                                    <a href="javascript:void(0)"
                                       title="{{optional($row->user)->username}}" class="position-relative">
                                        <img src="{{getFile(optional($row->user)->image_driver, optional($row->user)->image)}}"
                                             class="rounded-circle"
                                             width="35" height="35" alt="Sample Image">
                                        <i class="active-light position-absolute fa fa-circle text-{{(optional($row->user)->LastSeenActivity == true) ?trans('success'):trans('warning') }} font-12"
                                           title="{{(optional($row->user)->LastSeenActivity == true) ?trans('Online'):trans('Away') }}"></i>
                                    </a>

                                    <span class="d-block mt-3 base-color"><sup>{{basicControl()->currency_symbol}}</sup>{{getAmount($row->amount)}}</span>
                                </div>

                                <div class="flex-grow-1 ms-3">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-start ">
                                            <h6>{{optional($row->user)->fullname}}</h6>
                                            <span
                                                class="ms-3 base-color">{{optional($row->sellPost)->title}}</span>
                                        </div>
                                        @if($row->author_id == auth()->id())
                                            <div class="btn-group btn-group-sm" role="group">
                                                <div class="btn-group" role="group">
                                                    <button id="offerActionBtn" type="button"
                                                            class="btn text-white dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    <ul class="dropdown-menu" aria-labelledby="offerActionBtn">
                                                        @if ($row->status != 1 && $row->author_id == auth()->id())
                                                            <li>
                                                                <a class="dropdown-item offerAccept"
                                                                   href="javascript:void(0)"
                                                                   data-resource="{{ $row->id }}"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#offerAccept">
                                                                    <i class="text-success fa fa-check-circle"></i> @lang('Accept')
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('user.offerChat', $row->uuid) }}">
                                                                    <i class="text-success fa fa-comment"></i> @lang('Conversation')
                                                                </a>
                                                            </li>
                                                        @endif

                                                        @if (($row->status == 0 || $row->status == 3) && $row->author_id == auth()->id())
                                                            <li>
                                                                <a class="dropdown-item offerReject"
                                                                   href="javascript:void(0)"
                                                                   data-resource="{{ $row->id }}"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#offerReject">
                                                                    <i class="text-danger fa fa-times"></i> @lang('Reject')
                                                                </a>
                                                            </li>
                                                        @endif

                                                        @if (($row->status == 2 || $row->status == 0 || $row->status == 3) && $row->author_id == auth()->id())
                                                            <li>
                                                                <a class="dropdown-item offerRemove"
                                                                   href="javascript:void(0)"
                                                                   data-resource="{{ $row->id }}"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#offerRemove">
                                                                    <i class="text-danger fa fa-trash-alt"></i> @lang('Remove')
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>

                                                </div>
                                            </div>
                                        @else
                                            @if($row->status == 1)
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <div class="btn-group" role="group">
                                                        <button id="offerActionBtn" type="button"
                                                                class="btn text-white dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>

                                                        <ul class="dropdown-menu" aria-labelledby="offerActionBtn">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('user.offerChat', $row->uuid) }}">
                                                                    <i class="text-success fa fa-comment"></i> @lang('Conversation')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                    <div class="d-flex ">

                                        @if(optional($row->sellPost)->payment_lock == 1 && optional($row->sellPost)->lock_for == $row->user_id && optional($row->sellPost)->payment_status ==0 && \Carbon\Carbon::now() < Carbon\Carbon::parse(optional($row->sellPost)->lock_at)->addMinutes(basicControl()->payment_expired))
                                            <span
                                                class="badge text-bg-warning">@lang('Payment Processing')</span>
                                        @elseif(optional($row->sellPost)->payment_lock == 1 && optional($row->sellPost)->lock_for == $row->user_id && optional($row->sellPost)->payment_status ==1)
                                            <span
                                                class="badge text-bg-success">@lang('Payment Completed')</span>

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
                            <hr>
                        @empty
                            @include('empty')
                        @endforelse


                        @if(0 < $sellPostOffer->total())
                            <div class="row justify-content-between align-items-center mt-3">
                                <div class="col-md-4">
                                    <span>@lang('SHOWING ALL') {{$sellPostOffer->total()}} @lang('RESULTS')</span>

                                </div>
                                <div class="col-md-8">
                                    {{$sellPostOffer->appends($_GET)->links(template().'partials.pagination')}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Offer List Search')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.sellPostOfferMore')}}" method="get">
                <div class="row g-4">
                    <div>
                        <select name="postId" class="form-control modal-select">
                            <option value="">@lang('My All Post')</option>
                            @forelse($sellPostAll as $item)
                                <option @if(@request()->postId == $item->id) selected
                                        @endif value="{{$item->id}}">@lang($item->title)</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Remark')</label>
                        <input type="text" name="remark"
                               value="{{old('remark',@request()->remark)}}"
                               class="form-control form-control-sm"
                               placeholder="@lang("Type  user or message")">
                    </div>
                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Date')</label>
                        <input type="date" class="form-control form-control-sm" name="datetrx"
                               id="date">
                    </div>

                    <div class="btn-area">
                        <button type="submit" class="cmn-btn">@lang('Filter')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Offer Accept Model -->
    <div class="modal fade" id="offerAccept" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="offerAcceptLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="offerAcceptLabel">@lang('Accept Offer')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
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
    <div class="modal fade" id="offerRemove" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="offerRemoveLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="offerRemoveLabel">@lang('Remove Offer')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <form action="{{route('user.sellPostOfferRemove')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="removeOfferId" name="offer_id" value="">
                        <label>@lang('Are you want to remove this offer?')</label>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="cmn-btn2">@lang('Yes')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Offer Reject Model -->
    <div class="modal fade" id="offerReject" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="offerRejectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="offerRejectLabel">@lang('Reject Offer')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <form action="{{route('user.sellPostOfferReject')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="rejectOfferId" name="offer_id" value="">
                        <label>@lang('Are you want to reject this offer?')</label>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success-custom">@lang('Yes')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('assets/global/css/flatpickr.min.css')}}">
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        .card-body {
            padding: 20px;
        }

        hr {
            border-top: 1px solid #f0f0f0;
        }

        .user img {
            border: 2px solid #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
        }

        .user .active-light {
            right: 0;
            top: -14px;
            font-size: 13px;
        }

        .base-color {
            color: #007bff;
            font-weight: 600;
        }

        .flex-shrink-0 {
            margin-right: 20px;
            text-align: center;
        }

        .flex-grow-1 {
            margin-left: 20px;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: #ffffff !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: #ffffff !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
            color: #ffffff !important;
        }

        .btn {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-group-sm .dropdown-menu {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .dropdown-toggle::after{
            display: none;
        }
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item .page-link {
            color: #007bff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
        }

        p {
            margin-top: 10px;
            line-height: 1.6;
            font-size: 14px;
            color: #6c757d;
        }

        small {
            color: #6c757d;
            font-size: 12px;
        }

        .card-body .btn-group .btn {
            background-color: transparent;
            color: #000 !important;
        }
        .dark-theme .card-body .btn-group .btn {
            color: #fff !important;
        }

    </style>
@endpush
@push('script')
<script src="{{asset('assets/global/js/flatpickr.min.js')}}"></script>
    <script>
        'use strict';
        $(document).ready(function () {

            flatpickr("#date");

            $('.sortByAttempt').on('click', function () {
                const selectedSortBy = $(this).data('sortby');
                $('.sortby_field').val(selectedSortBy);
                $(this).closest('form').submit();
            });


            $('.makeOffer').on('click', function () {
                $('.sell_post_id').val($(this).data('resource'));
            });

            $(document).ready(function () {
                $('.offerRemove').on('click', function () {
                    $('.removeOfferId').val($(this).data('resource'));
                })
            });

            $(document).ready(function () {
                $('.offerReject').on('click', function () {
                    $('.rejectOfferId').val($(this).data('resource'));
                })
            });

            $(document).ready(function () {
                $('.offerAccept').on('click', function () {
                    $('.acceptOfferId').val($(this).data('resource'));
                })
            })
        })

    </script>

@endpush
