@extends(template().'layouts.user')
@section('title',trans('Direct Top Up Orders'))
@section('content')
    <div class="container">
        <div class="card mt-50">
            <div class="card-header">
                <div class="d-flex justify-content-between orderHeader">
                    <div class="headerwithmenu">
                        <h4 class="mb-3">@lang('Direct Top Up Orders')</h4>
                        <div class="order-filter-btn">
                            <a href="{{ route('user.topUpOrder') . '?type=all' }}"
                               class="cmn-btn3 nav {{ request()->type == 'all' ? 'active':'' }}">
                                @lang('All') <span></span>
                            </a>

                            <a href="{{route('user.topUpOrder').'?type=wait-sending'}}"
                               class="cmn-btn3 nav {{@request()->type=='wait-sending' ? 'active':''}}">@lang('Sending')
                                <span></span></a>

                            <a href="{{route('user.topUpOrder').'?type=complete'}}"
                               class="cmn-btn3 nav {{@request()->type=='complete' ? 'active':''}}">@lang('Completed')
                                <span></span></a>

                            <a href="{{route('user.topUpOrder').'?type=refund'}}"
                               class="cmn-btn3 nav {{@request()->type=='refund' ? 'active':''}}">@lang('Refund')
                                <span></span></a>
                        </div>
                    </div>

                    <div class="order-search-form">
                        <form action="{{route('user.topUpOrder')}}" method="GET">
                            <input type="hidden" name="type" value="all">
                            <input type="text" name="search" class="order-search" value="{{@request()->search}}"
                                   placeholder="@lang('Search Order')">
                            <button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        @if(count($orders) > 0)
                            @foreach($orders as $key => $order)
                                <div class="user-order_list">
                                    <div class="trade_wrp">
                                        <div class="trade_info">
                                            <div class="trade">
                                                <div class="pid">@lang('Order Id') <a
                                                        href="javascript:void(0)"> {{$order->utr}}</a>
                                                </div>
                                                <div class="time">{{dateTime($order->created_at)}}</div>
                                            </div>
                                            <div class="info">
                                                <div class="price"><b
                                                        class="pri">{{currencyPosition($order->amount)}}</b>
                                                </div>
                                                <div class="channel text-center">
                                                    @if($order->status == 0)
                                                        <span class="stat expired">@lang('Wait Sending')</span>
                                                    @elseif($order->status == 1)
                                                        <span class="stat expired">@lang('Completed')</span>
                                                    @elseif($order->status == 2)
                                                        <span class="stat expired">@lang('Refunded')</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="func">
                                                <div class="ordro-dropdown">
                                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-regular fa-ellipsis-v-alt"></i>
                                                    </button>
                                                    @php
                                                        $informations = null;
                                                          if(!empty($order->info)){
                                                           foreach ($order->info as $info){
                                                              $informations[$info->field] = $info->value;
                                                            }
                                                          }
                                                    @endphp
                                                    <ul class="dropdown-menu order-dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton1">
                                                        <li data-bs-toggle="modal" id="infoBtn"
                                                            data-bs-target="#detailModal"
                                                            data-info="{{json_encode($informations)}}">
                                                            <a class="dropdown-item"
                                                               href="javascript:void(0)">@lang('Information')</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order_info">
                                            @if(!empty($order->orderDetails))
                                                @foreach($order->orderDetails as  $detail)
                                                    @php
                                                        $topUpService = $detail->detailable;
                                                    @endphp
                                                    <div class="unit">
                                                        <div class="oid">
                                                            <a href="javascript:void(0)">@lang('SL-'){{++$key}}</a>
                                                            @if(isset($topUpService->topUp->reviewByReviewer))
                                                                @for($i=0;$i < $topUpService->topUp->reviewByReviewer->rating;$i++)
                                                                    <img src="{{asset('assets/admin/img/star.svg')}}" alt="Review rating" width="14">
                                                                @endfor
                                                                @for($i=0; $i < (5 - $topUpService->topUp->reviewByReviewer->rating); $i++)
                                                                    <img src="{{asset('assets/admin/img/star_unfilled.png')}}" alt="Review rating" width="14">
                                                                @endfor
                                                            @endif
                                                        </div>
                                                        <div class="item">
                                                            <a href="{{route('topUp.details',$topUpService->topUp?->slug)}}"><img
                                                                    src="{{$topUpService->imagePath()}}" alt="image"></a>
                                                            <div class="item-info">
                                                                <div class="name">{{$detail->name}}</div>
                                                                <div class="sku">{{$topUpService->topUp?->name}}</div>
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
                </div>
            </div>
        </div>
        {{ $orders->appends($_GET)->links(template().'partials.pagination') }}
    </div>
    @include(template()."user.".getDash().".order.topup.modal")
@endsection

@push('script')
    <script>
        'use strict';
        $(document).on("click", "#infoBtn", function () {
            let info = $(this).data('info');
            $('.order_information').html('');
            let list = "";
            Object.keys(info).forEach(key => {
                list += `<li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-capitalize">${key}</span>
                        <span>${info[key]}</span>
                    </div>
                </li>`
            });
            $('.order_information').html(list);
        });
    </script>
@endpush
