@extends('admin.layouts.app')
@section('page_title','Order Details')
@section('content')
    <div class="content container-fluid">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="{{route('admin.orderCard.view')}}">@lang('Orders')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Order details')</li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">@lang('Order') {{$order->utr}}</h1>
                        <span class="badge bg-soft-success text-success ms-sm-3">
                            <span class="legend-indicator bg-success"></span>@lang('Paid')
                        </span>
                        @if($order->status == 3)
                            <span class="badge bg-soft-warning text-warning ms-2 ms-sm-3">
                              <span class="legend-indicator bg-warning"></span>@lang('Pending (stock-short)')</span>
                        @elseif($order->status == 1)
                            <span class="badge bg-soft-success text-success ms-2 ms-sm-3">
                              <span class="legend-indicator bg-success"></span>@lang('Complete')</span>
                        @elseif($order->status == 2)
                            <span class="badge bg-soft-secondary text-secondary ms-2 ms-sm-3">
                              <span class="legend-indicator bg-secondary"></span>@lang('Refund')</span>
                        @endif
                        <span class="ms-2 ms-sm-3">
                        <i class="bi-calendar-week"></i> {{dateTime($order->created_at)}}
                      </span>
                    </div>

                    <div class="mt-2">
                        <div class="d-flex gap-2">
                            @if($order->status == 3)
                                <div class="dropdown">
                                    <a class="text-body" href="javascript:;" id="moreOptionsDropdown"
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        @lang('More options') <i class="bi-chevron-down"></i>
                                    </a>

                                    <div class="dropdown-menu mt-1" aria-labelledby="moreOptionsDropdown">
                                        <a class="dropdown-item actionBtn" data-type="complete"
                                           data-id="{{$order->utr}}"
                                           data-route="{{route('admin.orderTopUp.complete')}}"
                                           data-bs-target="#orderStep"
                                           data-bs-toggle="modal"
                                           href="javascript:void(0)">
                                            <i class="bi-check dropdown-item-icon"></i> @lang('Complete order')
                                        </a>
                                        <a class="dropdown-item actionBtn" data-type="cancel" data-id="{{$order->utr}}"
                                           data-route="{{route('admin.orderTopUp.cancel')}}"
                                           data-bs-target="#orderStep"
                                           data-bs-toggle="modal"
                                           href="javascript:void(0)">
                                            <i class="bi-x dropdown-item-icon"></i> @lang('Cancel order')
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">@lang('Order details') <span
                                class="badge bg-soft-dark text-dark rounded-circle ms-1">{{count($order->orderDetails)}}</span>
                        </h4>
                        @if($order->payment_method_id == '-1')
                            <span>@lang('Pay Via Wallet')</span>
                        @else
                            <span>@lang('Pay Via '){{$order->gateway?->name}}</span>
                        @endif
                    </div>

                    <div class="card-body">

                        @if(!empty($order->orderDetails))
                            @foreach($order->orderDetails as $detail)
                                @php
                                    $cardService = $detail->detailable;
                                @endphp

                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-xl">
                                            <img class="img-fluid" src="{{$cardService->imagePath()}}"
                                                 alt="Image Description">
                                        </div>
                                    </div>

                                    <div class="flex-grow-1 ms-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <a class="h5 d-block"
                                                   href="{{ route('admin.cardService.list') . '?card_id=' . $cardService->card_id}}">{{$detail->name}}</a>

                                                <div class="fs-6 text-body">
                                                    <span>@lang('Category'):</span>
                                                    <span class="fw-semibold">{{$cardService->card?->name}}</span>
                                                </div>
                                                <a class="link seeCode" data-codes="{{$detail->card_codes}}"
                                                   data-order_qty="{{$detail->qty}}"
                                                   data-stock_short="{{$detail->stock_short}}"
                                                   data-detail_id="{{$detail->id}}"
                                                   href="javascript:;" data-bs-target="#seeCode"
                                                   data-bs-toggle="modal">@lang('See Codes') {{$detail->status == 3 ? '- (stock-short)' :''}}</a>
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                <h5>{{currencyPosition(getAmount($detail->price - $detail->discount))}}</h5>
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                <h5>{{$detail->qty}}</h5>
                                            </div>

                                            <div class="col col-md-2 align-self-center text-end">
                                                <h5>{{currencyPosition(getAmount($detail->qty * ($detail->price - $detail->discount)))}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @endif

                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-8 col-lg-7">
                                <dl class="row text-sm-end">
                                    <dt class="col-sm-6">@lang('Amount paid'):</dt>
                                    <dd class="col-sm-6">{{currencyPosition($order->amount)}}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">@lang('User')</h4>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush list-group-no-gutters">
                            <li class="list-group-item">
                                <a class="d-flex align-items-center"
                                   href="{{route('admin.user.view.profile', $order->user_id)}}">
                                    <div class="avatar avatar-circle">
                                        <img class="avatar-img"
                                             src="{{getFile($order->user?->image_driver,$order->user?->image)}}"
                                             alt="Image Description">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="text-body text-inherit">{{$order->user?->fullname}}</span>
                                    </div>
                                    <div class="flex-grow-1 text-end">
                                        <i class="bi-chevron-right text-body"></i>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <a class="d-flex align-items-center" target="_blank"
                                   href="{{route('admin.user.cardOrder.list',$order->user_id)}}">
                                    <div class="icon icon-soft-info icon-circle">
                                        <i class="bi-basket"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span
                                            class="text-body text-inherit">{{$userTotalOrderCount}} @lang('orders')</span>
                                    </div>
                                    <div class="flex-grow-1 text-end">
                                        <i class="bi-chevron-right text-body"></i>
                                    </div>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>@lang('Coupon info')</h5>
                                </div>

                                @if($order->coupon_code)
                                    <ul class="list-unstyled text-body">
                                        <li>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <h5 class="me-3">@lang('Code:')</h5> <h5>{{$order->coupon_code}} <a
                                                        target="_blank" class="ms-3"
                                                        href="{{route('admin.couponEdit',$order->coupon_id)}}"><i
                                                            class="fa-light fa-external-link-alt"></i></a></h5>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <h5 class="me-3">@lang('Discount Amount:')</h5>
                                                <h5>{{currencyPosition($order->discount)}}</h5>
                                            </div>
                                        </li>
                                    </ul>
                                @else
                                    @lang('No Coupon Apply')
                                @endif
                            </li>

                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>@lang('Contact info')</h5>
                                </div>

                                <ul class="list-unstyled list-py-2 text-body">
                                    <li><i class="bi-at me-2"></i>{{$order->user?->email}}</li>
                                    <li>
                                        <i class="bi-phone me-2"></i>{{$order->user?->phone_code}} {{$order->user?->phone}}
                                    </li>
                                    <li>
                                        <i class="bi-credit-card me-2"></i>{{currencyPosition($order->user?->balance)}}
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="seeCode" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{route('admin.orderCard.codeSend')}}" method="POST">
                    @csrf
                    <input type="hidden" name="orderDetailsId" value="">
                    <div class="modal-header">
                        <h3>@lang('Code List')</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger" id="message"></p>
                        <label class="form-label">@lang('Pass Code')</label>
                        <div class="showPassCode">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderStep" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalHeader"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="ModalBody"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="ModalRoute">
                        @csrf
                        <input type="hidden" name="orderId" value="">
                        <button type="submit" class="btn btn-soft-success" id="yesBtn">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        'use strict';

        $(document).on("click", ".actionBtn", function () {
            if ($(this).data('type') === 'complete') {
                $('#ModalHeader').html(`<i class="fas fa-check"></i> Complete Confirmation`);
                $('#ModalBody').text('Are you certain you want to proceed with the completion?');
                $('#yesBtn').addClass('btn btn-soft-success');
            } else {
                $('#ModalHeader').html(`<i class="fas fa-close"></i> Cancel Confirmation`);
                $('#ModalBody').text('Are you certain you want to proceed with the cancellation?');
                $('#yesBtn').addClass('btn btn-soft-danger');
            }
            $('input[name="orderId"]').val($(this).data('id'));
            $('.ModalRoute').attr('action', $(this).data('route'));
        });

        function copyFunction(element) {
            var copyText = document.getElementById(element);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }

        $(document).on("click", ".seeCode", function () {
            let codes = $(this).data('codes');
            let order_qty = $(this).data('order_qty');
            let stock_short = $(this).data('stock_short');

            $('input[name="orderDetailsId"]').val($(this).data('detail_id'));

            $('.showPassCode').html('');
            let showLists = "";
            let message = "";
            if (stock_short) {
                message = `Please add ${stock_short} more code and send to buyer to complete order`;
            }
            $('#message').text(message);

            for (let i = 0; i < order_qty; i++) {
                let placeholder = "";
                if (!codes[i]) {
                    codes[i] = "";
                    placeholder = "Please add code";
                }

                let element = 'referralsKeyCode' + i;

                showLists += `<div class="row mt-2">
                            <div class="col-md-12">
                                <div class="input-group input-group-sm input-group-merge table-input-group">
                                    <input id="${element}" type="text" name="passcode[]" class="form-control"
                                           value="${codes[i]}" placeholder="${placeholder}">
                                    <a class="js-clipboard input-group-append input-group-text" onclick="copyFunction('${element}')"
                                       title="Copy to clipboard">
                                        <i id="referralsKeyCodeIcon${i}" class="bi-clipboard" style="cursor: pointer"></i>
                                    </a>
                                </div>
                            </div>
                        </div>`;
            }
            $('.showPassCode').append(showLists);
        });
    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif
@endpush
