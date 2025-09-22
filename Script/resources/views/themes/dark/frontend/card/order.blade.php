@extends(template() . 'layouts.app')
@section('title',trans('Card Payment'))
@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/nice-select.css')}}"/>
@endpush
@section('content')
    <section class="checkout-section">
        <div class="container">
            <form action="{{route('card.user.order').'?utr='.$order->utr}}" method="POST" id="paymentForm">
                @csrf

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-15">@lang('How would you like to pay')?</h4>
                                <div class="payment-section">
                                    <ul class="payment-container-list">
                                        <li class="item">
                                            <input class="form-check-input methodId" type="radio" value="-1"
                                                   name="gateway_id"
                                                   id="wallet" checked>
                                            <label class="form-check-label" for="wallet">
                                                <div class="image-area">
                                                    <img src="{{asset(template(true).'img/wallet.png')}}"
                                                         alt="@lang('Wallet Payment')">
                                                </div>
                                                <div class="content-area">
                                                    <h5>@lang('Wallet Payment')</h5>
                                                    <span>@lang('Payment from your wallet balance')</span>
                                                </div>
                                            </label>

                                        </li>
                                        @if(!empty($gateways))
                                            @foreach($gateways as $key => $gateway)
                                                <li class="item">
                                                    <input class="form-check-input methodId" type="radio"
                                                           value="{{ $gateway->id }}"
                                                           name="gateway_id"
                                                           id="wallet{{$key}}">
                                                    <label class="form-check-label" for="wallet{{$key}}">
                                                        <div class="image-area">
                                                            <img src="{{getFile($gateway->driver,$gateway->image)}}"
                                                                 alt="{{$gateway->name}}">
                                                        </div>
                                                        <div class="content-area">
                                                            <h5>{{$gateway->name}}</h5>
                                                            <span>{{$gateway->description}}</span>
                                                        </div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <!-- Payment section end -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="side-bar">

                        </div>


                        <div class="paymentModal">
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                 data-bs-keyboard="false" tabindex="-1"
                                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="staticBackdropLabel">@lang('Payment')</h4>
                                            <button type="button" class="cmn-btn-close text-white"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa-light fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="paymentModalBody">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('js-lib')
    <script src="{{ asset(template(true) . 'js/jquery.nice-select.min.js')}}"></script>
    <style>
        .search-box2 .searchBtn {
            transition: var(--transition);
            position: absolute;
            right: 6px;
            background-color: rgb(var(--primary-color));
            height: calc(100% - 12px);
            border-radius: 9999px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgb(var(--white));
            text-transform: capitalize;
            gap: 10px;
            font-size: 16px;
        }

        .search-box2 .searchBtn:hover {
            background-color: rgb(var(--primary-color), 0.8);
            color: rgb(var(--white));
        }

        .rtl .search-box2 .form-control {
            padding: 6px 12px 6px 115px;
        }

        .rtl .search-box2 .searchBtn {
            right: auto;
            left: 5px;
        }

        @media (max-width: 575px) {
            .rtl .search-box2 .form-control {
                padding: 6px 12px 6px 85px;
            }
        }

        .nice-select.right {
            color: #fff;
            border: var(--border-color2);
        }

        .card {
            border: 1px solid var(--border-color2);
        }
    </style>
@endpush
@push('extra_scripts')
    <script>
        'use strict'

        let amountField = "{{getAmount($order->amount,2)}}";
        let discount = "{{getAmount($order->discount,2)}}";
        let amountStatus = false;
        let selectedGateway = -1;
        let baseCurrency = "{{session()->get('currency_symbol', basicControl()->currency_symbol)}}";
        let convertRate = "{{session()->get('currency_rate', 1)}}";

        calculateAmount();

        $(document).on('click', '.methodId', function () {
            calculateAmount();
        });

        function calculateAmount() {
            selectedGateway = $('.methodId:checked').val();
            let orderNumber = '{{$order->utr}}';
            let createdAt = '{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d M H:i') }}';
            const validAmount = amountField || 0;

            let html = `
                <div class="transferList">
                    <div class="card mb-20">
                        <div class="card-body">
                            <h5 class="mb-10">@lang('Have a Coupon Code')?</h5>
                            <div class="search-box2">
                                <input type="text" class="form-control mobileCoupon" id="couponCode" placeholder="@lang('Coupon code')">
                                <button type="button" class="searchBtn" onclick="couponApply('${orderNumber}')">@lang('Apply')</button>
                            </div>
                            <span class="" id="couponMsg"></span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-20">@lang('Order Summary')</h4>
                            <div class="cmn-list2">
                                <div class="item">
                                    <span>@lang('Order Number')</span>
                                    <h6 class="mb-0">${orderNumber}</h6>
                                </div>
                                <div class="item">
                                    <span>@lang('Created')</span>
                                    <h6 class="mb-0">${createdAt}</h6>
                                </div>
                                <div class="item text-success">
                                    <span>@lang('Discount') :</span>
                                    <h6 class="mb-0 text-success" id="discount">${baseCurrency}${amountConvert(discount)}</h6>
                                </div>
                                <div class="item">
                                    <span>@lang('Total Price') :</span>
                                    <h6 class="mb-0" id="totalPrice">${baseCurrency}${amountConvert(amountField)}</h6>
                                </div>
                                <div class="item d-none" id="currency-box">
                                    <span>@lang('Select Currency') :</span>
                                    <div class="nice-select-section">
                                        <select class="nice-select right" id="supported_currency">
                                            <option data-display="Select">@lang('Select')</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="supported_currency" value="">
                                </div>
                                <div class="item text-danger">
                                    <span>@lang('Payment Fees') :</span>
                                    <h6 class="mb-0 showCharge text-danger">0 ${baseCurrency}</h6>
                                </div>
                                <hr>
                                <div class="item">
                                    <h5>@lang('Total') :</h5>
                                    <h5 class="mb-0" id="payable">${baseCurrency}${amountConvert(amountField)}</h5>
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn2 mt-20 w-100" ${validAmount > 0 ? '' : 'disabled'}>
                                <span>@lang('pay securely')</span>
                            </button>
                        </div>
                    </div>
                </div>`;

            let updatedWidth = window.innerWidth;
            window.addEventListener('resize', () => {
                updatedWidth = window.innerWidth;
            });

            if (updatedWidth <= 991) {
                $('.side-bar').html('');
                $('#paymentModalBody').html(html);
                let paymentModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                paymentModal.show();
            } else {
                $('.side-bar').html(html);
            }

            if (selectedGateway !== '-1') {
                $('#currency-box').removeClass('d-none');
                supportCurrency(selectedGateway);
            } else {
                $('#currency-box').addClass('d-none');
                $('.showCharge').html(`{{ userCurrencyPosition(0) }}`);
                $('#payable').html(`${baseCurrency}${amountField}`);
            }
        }


        function supportCurrency(selectedGateway) {
            if (!selectedGateway) {
                console.error('Selected Gateway is undefined or null.');
                return;
            }
            $('#supported_currency').empty();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('supported.currency') }}",
                data: {gateway: selectedGateway},
                type: "GET",
                success: function (response) {
                    $('#supported_currency').html('<option data-display="Select">@lang("Select")</option>');

                    if (!response.data || response.data.length === 0) {
                        $('#supported_currency').append(`<option value="USD">USD</option>`);
                    } else {
                        response.data.forEach(function (value, index) {
                            let isSelected = index === 0 ? 'selected' : '';
                            $('#supported_currency').append(`<option value="${value}" ${isSelected}>${value}</option>`);
                        });
                        $('#supported_currency').trigger('change');
                    }
                    if ($('.nice-select').length) {
                        $('.nice-select').niceSelect('update');
                    }

                    let selectedCurrency = $('#supported_currency').val();
                    $('input[name="supported_currency"]').val(selectedCurrency);
                    checkAmount(amountField, selectedCurrency, selectedGateway);
                },
                error: function (error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        $(document).on("change", ".nice-select", function () {
            let amount = amountField;
            let selectedCurrency = $(this).val();
            $('input[name="supported_currency"]').val(selectedCurrency);
            let currency_type = 1;

            if (!isNaN(amount) && amount > 0) {
                checkAmount(amount, selectedCurrency, selectedGateway);

                if (selectedCurrency != '-1') {
                }
            } else {
                $('.showCharge').html('');
            }
        });


        function checkAmount(amount, selectedCurrency, selectGateway) {
            $.ajax({
                method: "GET",
                url: "{{ route('deposit.checkAmount') }}",
                dataType: "json",
                data: {
                    'amount': amount,
                    'selected_currency': selectedCurrency,
                    'select_gateway': selectGateway,
                    'amountType': 'yes',
                }
            }).done(function (response) {
                let amountField = $('#amount');
                if (response.status) {
                    amountStatus = true;
                    showCharge(response, response.currency);
                } else {
                    amountStatus = false;
                    showCharge(response, response.currency);
                    Notiflix.Notify.failure(response.message);
                }
                submitBtn(response.message);
            });
        }

        function submitBtn(message) {
            if (amountStatus) {
                $('#submitBtn').attr('disabled', false);
                $('#note').text('');
            } else {
                $('#submitBtn').attr('disabled', true);
                $('#note').text(`Note: ${message}`);
            }
        }

        function showCharge(response, currency) {
            let charge = (response.charge).toFixed(2);
            let amount = (response.payable_amount).toFixed(2);
            $('.showCharge').html(`${charge} ${response.currency}`);
            $('#payable').html(`${amount} ${response.currency}`);
        }

        function couponApply(utr) {
            let couponCode = $("#couponCode").val();
            axios.post('{{ route('topUp.user.couponApply') }}',
                {
                    utr: utr,
                    couponCode: couponCode
                })
                .then(response => {
                    let res = response.data;
                    if (res.status == 'success') {
                        discount = res.discount;
                        $("#couponMsg").removeClass('text-danger').addClass('text-success').text(res.message);
                        $("#discount").text(`${baseCurrency}${amountConvert(discount)}`);
                        $("#totalPrice").text(res.total_amount);
                        $("#payable").text(res.total_amount);
                        amountField = res.amount;

                        if (selectedGateway && selectedGateway != '-1') {
                            let selectedCurrency = $('#supported_currency').val();
                            localStorage.setItem('selectedCurrency', selectedCurrency);
                            checkAmount(amountField, selectedCurrency, selectedGateway)
                        }
                    }
                    if (res.status == 'error') {
                        $("#couponMsg").removeClass('text-success').addClass('text-danger').text(res.message);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }

        $(document).ready(function () {
            $('#wallet').prop('checked', true).trigger('click');
        });

        function amountConvert(amount) {
            return (amount * convertRate).toFixed(2)
        }
    </script>
@endpush

