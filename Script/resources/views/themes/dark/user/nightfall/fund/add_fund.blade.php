@extends(template().'layouts.user')
@section('title',trans('Add Fund'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Add Fund')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Add Fund')</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4">
        <div class="col-lg-7 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-15">@lang('How would you like to pay?')</h4>
                    <form action="{{route('payment.request')}}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="supported_currency" value="">
                        <input type="hidden" name="amount" value="">
                        <div class="payment-section">
                            <ul class="payment-container-list">
                                @if(!empty($gateways))
                                    @foreach($gateways as $key => $gateway)
                                        <li class="item">
                                            <input class="form-check-input methodId" type="radio"
                                                   value="{{ $gateway->id }}" name="gateway_id"
                                                   id="wallet{{ $key }}" {{ $key == 0 ? 'checked':'' }}>
                                            <label class="form-check-label" for="wallet{{$key}}">
                                                <div class="image-area">
                                                    <img src="{{getFile($gateway->driver,$gateway->image)}}" alt="...">
                                                </div>
                                                <div class="content-area">
                                                    <h5>{{$gateway->name}}</h5>
                                                </div>
                                            </label>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="side-bar">

            </div>

            <div class="paymentModal">
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="staticBackdropLabel">@lang('Payment')</h4>
                                <button type="button" class="cmn-btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times text-light"></i>
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
@endsection
@push('script')
    <style>
        .delete-btn{
            border-radius: 9999px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {

            $('.cmn-select2').select2({
                placeholder: "Select currency"
            });

            let amountField = $('#amount');
            let amountStatus = false;
            let selectedGateway = null;
            let baseCurrency = "{{basicControl()->currency_symbol}}";

            selectedGateway = $('.methodId').val();


            $('#gatewayImg').attr('src', $('.methodId').data('img'))

            $(document).on("click", "#submitBtn", function () {
                $('#paymentForm').submit();
            });

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }
            calculateAmount();

            $(document).on('click', '.methodId', function () {
                calculateAmount();
            });

            function calculateAmount(){
                $('.showCharge').html(`${baseCurrency}0.00`);
                selectedGateway = $('.methodId:checked').val();

                let updatedWidth = window.innerWidth;
                window.addEventListener('resize', () => {
                    updatedWidth = window.innerWidth;
                });

                let html = `
                    <div class="transferList">
                        <div class="card">
                            <div class="card-body addFundCardBody">
                                <div class="transfer-details-section">
                                    <ul class="transfer-list nightfallTransferList">
                                        <li class="item title">
                                            <h5>@lang('Funding Details')</h5>
                                        </li>
                                        <li class="item">
                                            <span>@lang('Select Currency')</span>
                                            <div class="w-10">
                                                <select class="cmn-select2" id="supported_currency">
                                                </select>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <span>@lang('Amount')</span>
                                            <div class="w-10">
                                                <input type="number" id="amount" class="form-control" value="0">
                                                <div class="invalid-feedback">
                                                    @error('amount') @lang($message) @enderror
                                                </div>
                                                <div class="valid-feedback"></div>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <span>@lang('Funding Amount')</span>
                                            <span id="fundingAmount">{{basicControl()->currency_symbol}} 0.00</span>
                                        </li>
                                        <li class="item text-danger">
                                            <span>@lang('Payment Fees')</span>
                                            <span class="showCharge text-danger">{{basicControl()->currency_symbol}} 0.00</span>
                                        </li>
                                        <li class="item">
                                            <span>@lang('You send exactly')</span>
                                            <h5 id="payable">{{basicControl()->currency_symbol}} 0.00</h5>
                                        </li>
                                    </ul>
                                    <a href="javascript:void(0)" class="cmn-btn w-100" id="submitBtn">@lang('confirm and continue')</a>
                                    <a href="javascript:history.back()" class="delete-btn mt-20 w-100">@lang('cancel')</a>
                                </div>
                            </div>
                        </div>
                    </div>`;

                if (updatedWidth <= 991) {
                    $('.side-bar').html('');
                    $('#paymentModalBody').html(html);
                    let paymentModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                    paymentModal.show();
                } else {
                    $('.side-bar').html(html);
                }

                $('.cmn-select2').select2({
                    placeholder: "Select currency"
                });

                supportCurrency(selectedGateway);
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
                    success: function (data) {
                        if (data === "") {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        let res = data.data;
                        $(res).each(function (index, value) {
                            let markup = `<option value="${value}">${value}</option>`;
                            $('#supported_currency').append(markup);
                        });
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            $(document).on("keyup", "#amount", function () {
                let amount = $('#amount').val();
                $('input[type="hidden"][name="amount"]').val(amount);
                let selectedCurrency = $('#supported_currency').val();
                $('input[name="supported_currency"]').val(selectedCurrency);

                let currency_type = 1;
                if (!isNaN(amount) && amount > 0) {
                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;
                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        $('#amount').val(amount);
                    }
                    checkAmount(amount, selectedCurrency, selectedGateway)

                    if (selectedCurrency != null) {

                    }
                } else {
                    $('.showCharge').html('')
                }
            });

            $(document).on("change", "#supported_currency", function () {
                let amount = $('#amount').val();
                let selectedCurrency = $('#supported_currency').val();
                $('input[name="supported_currency"]').val(selectedCurrency);
                let currency_type = 1;
                if (!isNaN(amount) && amount > 0) {
                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;
                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        $('#amount').val(amount);
                    }
                    checkAmount(amount, selectedCurrency, selectedGateway)
                } else {
                    $('.showCharge').html('')
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
                        'amountType': 'other',
                    }
                }).done(function (response) {
                    let amountField = $('#amount');
                    if (response.status) {
                        clearMessage(amountField);
                        amountStatus = true;
                        showCharge(response, response.currency);
                    } else {
                        amountStatus = false;
                        $(amountField).addClass('is-invalid');
                        $(amountField).closest('div').find(".invalid-feedback").html(response.message);
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
                $('.showCharge').html(`${parseFloat(response.charge).toFixed(2)} ${response.currency}`);
                $('#payable').html(`${parseFloat(response.payable_amount).toFixed(2)} ${response.currency}`);
                $('#fundingAmount').html(`${baseCurrency}${parseFloat(response.payable_amount_baseCurrency).toFixed(2)}`);
            }
        });
    </script>
@endpush






