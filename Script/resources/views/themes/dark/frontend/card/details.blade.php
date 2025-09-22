@extends(template() . 'layouts.app')
@section('title',trans('Card Details'))
@section('content')

    <!-- Banner section start -->
    <div class="banner-section">
        <div class="container">
            <div class="row g-4 g-xxl-5">
                <div class="col-lg-3 col-md-4">
                    <div class="img-box">
                        <img src="{{ getFile($card->image->image_driver,$card->image->image) }}" alt="{{$card->name}}">
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="text-box">
                        <h4 class="title">{{$card->name}}</h4>
                        @if($card->instant_delivery)
                            <div class="region mt-2"><i class="fa-regular fa-timer"></i>@lang('Instant Delivery')</div>
                        @endif
                        @if($card->region)
                            <div class="region mt-2"><i class="fa-regular fa-earth-americas"></i>{{ $card->region }}</div>
                        @endif
                        <div class="note-box mt-30">
                            <div class="icon-box"><i class="fa-solid fa-notes"></i></div>
                            <div class="text-box">
                                <h6 class="mb-1">@lang('Important Note:')</h6>
                                <p>@lang($card->note)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner section end -->


    <!-- Product details section start -->
    <section class="product-details-section">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    @if(!empty($card->activeServices))
                        <div class="row g-3">
                            @foreach($card->activeServices as $key => $service)
                                <div class="col-lg-6">
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
                                                <div class="title">{{$service->name}}</div>
                                            </div>
                                        </div>
                                        <div class="right-side">
                                            <div class="price">
                                                <div
                                                    class="promo-price">{{userCurrencyPosition(showActualPrice($service))}}</div>
                                                @if($service->discount)
                                                    <div
                                                        class="original-price line-through">{{userCurrencyPosition($service->price)}}</div>
                                                @endif
                                            </div>
                                            @if(count($service->activeCodes) < 1)
                                                <small>@lang('stock short')</small>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
                        </div>
                    </div>
                    <div class="sidebar-widget-area">
                        <div class="cmn-list2">
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
                        <button type="button" onclick="buyNow()" class="cmn-btn w-100 mt-20"><span
                                class="btn-ring2"></span> @lang('Buy Now')</button>
                        <button type="button" onclick="addToCart()"
                                class="cmn-btn2 w-100  mt-20"><span
                                class="btn-ring"></span> @lang('Add to Cart')</button>
                    </div>
                </div>
            </div>
            @include(template() . 'frontend.card.review')
        </div>
    </section>
@endsection

@push('style')
    <style>
        .nav-link.active {
            color: #fff !important;
        }
    </style>
@endpush

@push('extra_scripts')
    <script>
        'use strict';
        var activeGiftCard = $('.product-box2.active');
        var initialPrice = activeGiftCard.data('price').replace(/[^\d.]/g, "");
        var price = activeGiftCard.data('price').replace(/[^\d.]/g, "");
        var initialDiscount =  parseFloat(activeGiftCard.data('discount').replace(/[^\d.]/g, ""));
        var discount = parseFloat(activeGiftCard.data('discount').replace(/[^\d.]/g, ""));
        var serviceId = activeGiftCard.data('id');
        var newValue = 1;
        var currencySymbol = '{{ session()->get('currency_symbol', basicControl()->currency_symbol) }}';
        var isLogin = "{{auth()->check()}}";

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
                type: 'card',
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
