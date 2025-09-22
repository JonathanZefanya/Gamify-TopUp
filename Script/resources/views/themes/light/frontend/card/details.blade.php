@extends(template() . 'layouts.app')
@section('title',trans('Card Details'))
@section('content')
    <section class="product-details-section">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="product-details-header mb-50">
                        <div class="img-box">
                            <img src="{{ getFile($card->image->image_driver,$card->image->image) }}" alt="{{$card->name}}">
                        </div>
                        <div class="text-box">
                            <h4 class="mb-10">{{ $card->name }}</h4>
                            @if($card->instant_delivery)
                                <div class="region mt-2"><i class="fa-regular fa-timer"></i>@lang('Instant Delivery')</div>
                            @endif
                            @if($card->region)
                                <div class="region mt-2"><i class="fa-regular fa-earth-americas"></i>{{ $card->region }}</div>
                            @endif
                        </div>
                    </div>
                    @if(!empty($card->activeServices))
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">@lang('Denomination')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach($card->activeServices as $key => $service)
                                        <div class="col-lg-6 col-md-6">
                                            <a href="javascript:void(0)" class="product-box2 {{$key == 0 ? 'active':''}}"
                                               data-id="{{$service->id}}"
                                               data-symbol="{{basicControl()->currency_symbol}}"
                                               data-price="{{userCurrencyPosition(showActualPrice($service))}}"
                                               data-discount="{{userCurrencyPosition($service->getDiscount())}}">
                                                <div class="left-side">
                                                    <div class="img-box">
                                                        <img src="{{$service->imagePath()}}" alt="{{$service->name}}">
                                                    </div>
                                                    <div class="text-box">
                                                        <div class="title"> {{ $service->name }}</div>
                                                        @if(count($service->activeCodes) < 1)
                                                            <small class="text-danger">@lang('stock short')</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="right-side">
                                                    <div class="price flex-column gap-0">
                                                        <div
                                                            class="promo-price">{{userCurrencyPosition(showActualPrice($service))}}</div>
                                                        @if($service->discount)
                                                            <div
                                                                class="original-price line-through">{{userCurrencyPosition($service->price)}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @include(template().'frontend.card.review')
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-widget-area">
                        <div class="cmn-list2">
                            <div class="item">
                                <div class="list-label">@lang('Quantity')</div>
                                <div class="item-count">
                                    <button class="btn-inc-dec" data-decrease="data-decrease"
                                            onclick="quantityBtn(-1)"><i
                                            class="fa-regular fa-minus"></i></button>
                                    <input data-value="data-value" id="quantityNumber" type="number" value="1">
                                    <button class="btn-inc-dec" data-increase="data-increase"
                                            onclick="quantityBtn(1)"><i
                                            class="fa-regular fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="item">
                                <h5 class="mb-0">@lang('Total price')</h5>
                                <h5 class="mb-0" id="showPrice">0</h5>
                            </div>
                            <hr class="cmn-hr3 m-0">
                            <div class="item">
                                <div class="list-label">@lang('Discount')</div>
                                <div id="showDiscount">0</div>
                            </div>
                        </div>
                        <button type="button" onclick="buyNow()" class="cmn-btn w-100 mt-20">@lang('Buy Now')</button>
                        <button type="button" onclick="addToCart()" class="cmn-btn2 w-100  mt-20">@lang('add to cart')</button>
                    </div>
                    @include(template().'frontend.card.related')
                </div>
            </div>
        </div>

    </section>
@endsection
@push('extra_scripts')
    <script>
        'use strict';
        var activeGiftCard = $('.product-box2.active');
        var initialPrice = parseFloat(activeGiftCard.data('price').replace(/[^\d.]/g, ""));
        var price =  parseFloat(activeGiftCard.data('price').replace(/[^\d.]/g, ""));
        var initialDiscount =  parseFloat(activeGiftCard.data('discount').replace(/[^\d.]/g, ""));
        var discount = parseFloat(activeGiftCard.data('discount').replace(/[^\d.]/g, ""));
        var serviceId = activeGiftCard.data('id');
        var newValue = 1;
        var isLogin = "{{auth()->check()}}";
        var currencySymbol = '{{ session()->get('currency_symbol', basicControl()->currency_symbol) }}';
        showOrderInfo();

        $(document).on("click", ".product-box2", function () {
            initialPrice = $(this).data('price').replace(/[^\d.]/g, "");
            price = $(this).data('price').replace(/[^\d.]/g, "");
            initialDiscount = $(this).data('discount').replace(/[^\d.]/g, "");
            discount = $(this).data('discount').replace(/[^\d.]/g, "");
            serviceId = $(this).data('id');
            quantityBtn(0);
        });

        function quantityBtn(change) {
            const quantityElement = $('#quantityNumber');

            let currentValue = parseInt(quantityElement.val(), 10);
            newValue = currentValue + change;

            if (newValue < 1) {
                newValue = 1;
            } else if (newValue > 10) {
                newValue = 10;
            }

            quantityElement.val(newValue);
            price = (initialPrice * newValue).toFixed(2);
            discount = (initialDiscount * newValue).toFixed(2);
            showOrderInfo();
        }

        function showOrderInfo() {

            $('#showPrice').text(`${currencySymbol}${price}`);
            $('#showDiscount').text(`${currencySymbol}${discount}`);
            $('input[name="serviceId"]').val(serviceId);
        }

        function addToCart() {
            if (isLogin == false) {
                Notiflix.Notify.failure('Please Login before add to cart');
                return 0;
            }
            $(".btn-ring").show();
            axios.post("{{route('cart.user.addCart')}}", {
                serviceId: serviceId,
                quantity: newValue,
            })
                .then(function (response) {
                    $(".btn-ring").hide();
                    if (response.data.status) {
                        Notiflix.Notify.success('Added Cart');
                        cartCount();
                    } else {
                        Notiflix.Notify.failure(response.data.message);
                    }
                })
                .catch(function (error) {

                });
        }

        function buyNow() {
            if (isLogin == false) {
                Notiflix.Notify.failure('Please Login before purchase card');
                return 0;
            }

            $(".btn-ring2").show();
            axios.post("{{route('card.user.singleOrder')}}", {
                serviceId: serviceId,
                quantity: newValue,
            })
                .then(function (response) {
                    $(".btn-ring2").hide();
                    window.location.href = response.data.route;
                })
                .catch(function (error) {

                });
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
