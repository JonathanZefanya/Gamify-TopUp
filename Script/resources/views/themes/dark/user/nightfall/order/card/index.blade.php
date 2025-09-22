@extends(template().'layouts.user')
@section('title',trans('Card Orders'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Card Orders')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Card Orders')</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4>@lang('Card Orders')</h4>
                <div class="order-search-form">
                    <form action="{{route('user.cardOrder')}}" method="GET">
                        <input type="hidden" name="type" value="all">
                        <input type="text" name="search" class="order-search" value="{{@request()->search}}"
                               placeholder="@lang('Search Order')">
                        <button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
        </div>

        @if(count($orders) > 0)
            @foreach($orders as $key => $order)
                <div class="user-order_list">
                    <div class="trade_wrp">
                        <div class="trade_info">
                            <div class="trade">
                                <div class="pid">@lang('Order Id') <a href="javascript:void(0)"> {{$order->utr}}</a>
                                </div>
                                <div class="time">{{dateTime($order->created_at)}}</div>
                            </div>
                            <div class="info">
                                <div class="price"><b
                                        class="pri">{{currencyPosition($order->amount)}}</b></div>
                                <div class="channel text-center">
                                    @if($order->status == 3)
                                        <span class="stat expired">@lang('Wait Sending')</span>
                                    @elseif($order->status == 1)
                                        <span class="stat expired">@lang('Completed')</span>
                                    @elseif($order->status == 2)
                                        <span class="stat expired">@lang('Refunded')</span>
                                    @endif
                                </div>
                            </div>
                        </div>
{{--                        @dd($order->orderDetails)--}}
                        <div class="order_info">
                            @if(!empty($order->orderDetails))
                                @foreach($order->orderDetails as  $detail)
                                    @php
                                        $cardService = $detail->detailable;
                                    @endphp

                                    <div class="unit">
                                        <div class="oid">
                                            <a href="javascript:void(0)" class="seeCode"
                                               data-codes="{{$detail->card_codes}}"
                                               data-order_qty="{{$detail->qty}}"
                                               data-stock_short="{{$detail->stock_short}}"
                                               data-bs-target="#seeCode"
                                               data-bs-toggle="modal">@lang('See Codes')</a>

                                            @if(isset($cardService->card->reviewByReviewer))
                                                @for($i=0;$i < $cardService->card->reviewByReviewer->rating;$i++)
                                                    <img src="{{asset('assets/admin/img/star.svg')}}" alt="Review rating" width="14">
                                                @endfor
                                                @for($i=0; $i < (5 - $cardService->card->reviewByReviewer->rating); $i++)
                                                    <img src="{{asset('assets/admin/img/star_unfilled.png')}}" alt="Review rating" width="14">
                                                @endfor
                                            @endif

                                        </div>
                                        <div class="item">
                                            <a href="{{route('card.details',$cardService->card?->slug)}}"><img
                                                    src="{{$cardService->imagePath()}}" alt="image"></a>
                                            <div class="item-info">
                                                <div class="name">{{$detail->name}}</div>
                                                <div class="sku">{{$cardService->card?->name}}</div>
                                            </div>
                                        </div>
                                        <div class="amount">
                                            <div
                                                class="pri">{{currencyPosition($detail->price - $detail->discount)}}</div>
                                            <div class="qty">× {{$detail->qty}}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center">
                @include('empty')
            </div>
        @endif
    </div>
    {{ $orders->appends($_GET)->links(template().'partials.pagination') }}

    <div class="modal fade" id="seeCode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang('Code List')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p id="message"></p>
                            <label class="form-label mt-3"> @lang('Pass Codes')</label>
                            <div class="showPassCode">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        $(document).on("click", ".seeCode", function () {
            let codes = $(this).data('codes');
            let order_qty = $(this).data('order_qty');
            let stock_short = $(this).data('stock_short');
            $('.showPassCode').html('');
            let showLists = "";
            let message = "";
            if (stock_short) {
                message = `You have ${stock_short} more code in wait sending list`;
            }

            $('#message').text(message);

            for (let i = 0; i < order_qty; i++) {
                let placeholder = "";
                let type = "password";
                if (!codes[i]) {
                    codes[i] = "";
                    placeholder = "Wait Sending";
                    type = "text";
                }

                let element = 'codeVisible' + i;

                showLists += `<div class="withdraw-detail">
                                    <div class="input-group flex-nowrap mb-3">
<button class="input-group-text copy-btn" onclick="copyFunction('${element}')" type="button"><i
                                                    class="fa fa-copy" aria-hidden="true"></i></button>
                                        <div class="password-box">
                                            <i class="password-icon fa-regular fa-eye visibleBtn"></i>
                                            <input type="${type}" id="${element}"
                                                   class="form-control" value="${codes[i]}"
                                                   placeholder="${placeholder}">
                                        </div>
                                    </div>
                                </div>`;
            }
            $('.showPassCode').append(showLists);
        });


        $(document).on("click", '.visibleBtn', function (e) {
            let $passwordInput = $(this).closest('.password-box').find('input');
            if ($passwordInput.attr('type') == 'password') {
                $passwordInput.attr('type', 'text');
                $(this).children('i').removeClass('fa-regular fa-eye').addClass('fa-regular fa-eye-slash');
            } else {
                $passwordInput.attr('type', 'password');
                $(this).children('i').removeClass('fa-regular fa-eye-slash').addClass('fa-regular fa-eye');
            }
        });


        function copyFunction(element) {
            var copyText = document.getElementById(element);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush
