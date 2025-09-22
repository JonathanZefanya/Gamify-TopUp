@extends(template() . 'layouts.app')
@section('title',trans('Top Up Details'))
@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/nice-select.css')}}"/>
@endpush
@section('content')
    <section class="product-details-section">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="product-details-header mb-50">
                        <div class="img-box">
                            <img src="{{getFile($topUp->image->image_driver,$topUp->image->image)}}"
                                 alt="{{$topUp->name}}">
                        </div>
                        <div class="text-box">
                            <h4 class="title">{{$topUp->name}}</h4>
                            @if($topUp->instant_delivery)
                                <div class="region mt-2"><i class="fa-regular fa-timer"></i>@lang('Instant Delivery')</div>
                            @endif
                            @if($topUp->region)
                                <div class="region mt-2"><i class="fa-regular fa-earth-americas"></i>{{ $topUp->region }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">@lang('Denomination')</h5>
                        </div>
                        <div class="card-body">
                            @if(!empty($topUp->activeServices))
                                <div class="row g-4 mt-20">
                                    @foreach($topUp->activeServices as $key => $service)
                                        <div class="col-lg-6 col-md-6">
                                            <a href="javascript:void(0)" class="product-box2 {{$key == 0 ? 'active':''}}"
                                               data-id="{{$service->id}}"
                                               data-price="{{userCurrencyPosition(showActualPrice($service))}}"
                                               data-discount="{{userCurrencyPosition($service->getDiscount())}}">
                                                <div class="left-side">
                                                    <div class="img-box">
                                                        <img src="{{$service->imagePath()}}" alt="{{$service->name}}">
                                                    </div>
                                                    <div class="text-box">
                                                        <div class="title">{{$service->name}}</div>
                                                    </div>
                                                </div>
                                                <div class="right-side">
                                                    <div class="price flex-column gap-0">
                                                        <div class="promo-price">{{userCurrencyPosition(showActualPrice($service))}}</div>
                                                        @if($service->discount)
                                                            <div class="original-price line-through">{{userCurrencyPosition($service->price)}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @include(template().'frontend.topUp.review')

                </div>
                <div class="col-lg-4">
                    <form action="{{route('topUp.user.buy')}}" method="POST">
                        @csrf

                        <input type="hidden" name="topUpId" value="{{$topUp->id}}">
                        <input type="hidden" name="serviceId" value="">
                        <div class="sidebar-widget-area">
                            <div class="cmn-list2">
                                @if($topUp->order_information)
                                    @foreach($topUp->order_information as $info)
                                        @if($info->field_type == 'text')
                                            <div class="item">
                                                <div class="list-label">{{$info->field_value}}</div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <input class="form-control" type="text" name="{{$info->field_name}}"
                                                           placeholder="{{$info->field_placeholder}}" required>
                                                    @if($info->field_note)
                                                        <div class="info-box">
                                                            <div class="info-icon">
                                                                <i class="fa-regular fa-info-circle"></i>
                                                            </div>
                                                            <div class="info-text">
                                                                {{$info->field_note}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($info->field_type == 'select')
                                            <div class="item">
                                                <div class="list-label">{{$info->field_value}}</div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <div class="nice-select-section">
                                                        <select class="nice-select right" name="{{$info->field_name}}"
                                                                required>
                                                            @if($info->option)
                                                                @foreach($info->option as $key => $option)
                                                                    <option value="{{$key}}">{{$option}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    @if($info->field_note)
                                                        <div class="info-box">
                                                            <div class="info-icon">
                                                                <i class="fa-regular fa-info-circle"></i>
                                                            </div>
                                                            <div class="info-text">
                                                                {{$info->field_note}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                    <div class="item">
                                        <h5 class="mb-0">@lang('Total price')</h5>
                                        <h5 class="mb-0" id="showPrice"></h5>
                                    </div>
                                    <hr class="cmn-hr3 m-0">
                                    <div class="item">
                                        <div class="list-label">@lang('Discount')</div>
                                        <div id="showDiscount"></div>
                                    </div>
                            </div>
                            <button type="submit" class="cmn-btn w-100 mt-20">@lang('Buy Now')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js-lib')
    <script src="{{ asset(template(true) . 'js/jquery.nice-select.min.js')}}"></script>
@endpush
@push('extra_scripts')
    <script>
        'use strict';
        var activeGiftCard = $('.product-box2.active');
        var price = activeGiftCard.data('price');
        var discount = activeGiftCard.data('discount');
        var serviceId = activeGiftCard.data('id');
        showOrderInfo();

        $(document).on("click", ".product-box2", function () {
            price = $(this).data('price');
            discount = $(this).data('discount');
            serviceId = $(this).data('id');
            showOrderInfo();
        });

        function showOrderInfo() {
            $('#showPrice').text(price);
            $('#showDiscount').text(discount);
            $('input[name="serviceId"]').val(serviceId);
        }



        // Active class start
        const productBoxs = document.querySelectorAll('.product-box2');
        productBoxs.forEach(productBox => {
            productBox.addEventListener('click', () => {
                productBoxs.forEach(productBox => productBox.classList.remove('active'));
                productBox.classList.add('active');
            })
        })
        // Active class end

    </script>
@endpush
