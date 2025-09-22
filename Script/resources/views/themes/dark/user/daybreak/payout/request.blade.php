@extends(template().'layouts.user')
@section('title','Payout')
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Payout')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payout')</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('user.payout.request') }}" method="POST" id="paymentForm">
            @csrf
            <div class="row g-4">
                <div class="col-lg-7 col-md-12">
                    <div class="card">
                        @if(!config('withdrawaldays')[date('l')])
                            <div class="card-header">
                                <h5>@lang('Withdraw processing is off today. Please try' ) @foreach(config('withdrawaldays') as $key => $days)
                                        {{$days == 1 ? $key.',':''}}
                                    @endforeach</h5>

                            </div>
                        @endif
                        <div class="card-body">
                            <h4 class="mb-15">@lang('Preferred Payout Method')</h4>

                            <input type="hidden" name="supported_currency" value="">
                            <input type="hidden" name="amount" value="">
                            <div class="payment-section">
                                <ul class="payment-container-list">
                                    @if(!empty($payoutMethod))
                                        @foreach($payoutMethod as $key => $method)
                                            <li class="item">
                                                <input class="form-check-input selectPayoutMethod" type="radio"
                                                       value="{{ $method->id }}"
                                                       type="radio"
                                                       name="payout_method_id"
                                                       id="{{ $method->name }}"
                                                    {{ (old('gateway_id') == $method->id || $loop->first) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $method->name }}">
                                                    <div class="image-area">
                                                        <img src="{{getFile($method->driver,$method->logo)}}" alt="{{ $method->name }}">
                                                    </div>
                                                    <div class="content-area">
                                                        <h5>{{$method->name}}</h5>
                                                    </div>
                                                </label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="side-bar card p-4">
                    </div>
                    <div class="paymentModal">
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                             aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="staticBackdropLabel">@lang('Payment')</h4>
                                        <button type="button" class="cmn-btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="fas fa-times text-dark"></i>
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

@endsection

@push('style')
    <style>
        .no-data-image{
            width: 250px;
        }
        .wait-preview{
            padding: 20px;
        }
        .payment-preview-wait{
            padding: 50px;
        }
        .payoutSubmit{
            margin-top: 15px;
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict';

        $(document).ready(function () {
            let amountField = $('#amount');
            let amountStatus = false;
            let selectedPayoutMethod = "";

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }

            selectedPayoutMethod = $('.selectPayoutMethod').val();
            calculateAmount();

            $(document).on('click', '.selectPayoutMethod', function () {
                calculateAmount();
            });

            function calculateAmount() {
                selectedPayoutMethod = $('.selectPayoutMethod:checked').val();

                let updatedWidth = window.innerWidth;
                window.addEventListener('resize', () => {
                    updatedWidth = window.innerWidth;
                });

                let html = `
                    <div class="transferList">
                        <div class="side-box mt-2">
                            <div class="col-md-12 input-box mb-3">
                                <select
                                    class="js-example-basic-single form-control form-select"
                                    name="supported_currency"
                                    id="supported_currency">
                                    <option value="">@lang('Select Currency')</option>
                                </select>
                            </div>
                            <div class="col-md-12 input-box">
                                <div class="input-group">
                                    <input
                                        class="form-control @error('amount') is-invalid @enderror"
                                        name="amount"
                                        type="number" step="any" id="amount"
                                        placeholder="@lang('Enter Amount')"
                                        autocomplete="off"/>
                                    <div class="invalid-feedback">
                                        @error('amount') @lang($message) @enderror
                            </div>
                            <div class="valid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div id="payoutSummary">
                    <div class="row d-flex text-center justify-content-center">
                        <div class="col-md-12 payment-preview-wait">
                            <img src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                         id="no-data-image" class="no-data-image" alt=""
                                         srcset="">
                                    <p class="wait-preview">@lang('Waiting for payout preview')</p>
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

                $('.js-example-basic-single').select2({
                    placeholder: "@lang('Select Currency')"
                });

                supportCurrency(selectedPayoutMethod);
            }

            function supportCurrency(selectedPayoutMethod) {
                if (!selectedPayoutMethod) {
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
                    url: "{{ route('user.payout.supported.currency') }}",
                    data: {gateway: selectedPayoutMethod},
                    type: "GET",
                    success: function (data) {
                        $('#supported_currency').empty();

                        let markup = '<option value="" selected>@lang("Select Currency")</option>';
                        $('#supported_currency').append(markup);

                        $(data).each(function (index, value) {
                            let markup = `<option value="${value}">${value}</option>`;
                            $('#supported_currency').append(markup);
                        });

                        if (data.length > 0) {
                            $('#supported_currency').val(data[0]);
                        }
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }


            $(document).on('change, input', "#amount, #supported_currency, .selectPayoutMethod", function (e) {

                let amount = $('#amount').val();
                let selectedCurrency = $('#supported_currency').val();
                let currency_type = 1;

                if (!isNaN(amount) && amount > 0) {

                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;


                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        $('#amount').val(amount);
                    }

                    checkAmount(amount, selectedCurrency, selectedPayoutMethod)


                } else {
                    clearMessage($('#amount'))
                    $('#payoutSummary').html(`<div class="row d-flex text-center justify-content-center">
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                                        <p>@lang('Waiting for payout preview')</p>
                                                    </div>
                                                </div>`)
                }
            });


            function checkAmount(amount, selectedCurrency, selectedPayoutMethod) {

                $.ajax({
                    method: "GET",
                    url: "{{ route('user.payout.checkAmount') }}",
                    dataType: "json",
                    data: {
                        'amount': amount,
                        'selected_currency': selectedCurrency,
                        'selected_payout_method': selectedPayoutMethod,
                    }
                }).done(function (response) {
                    let amountField = $('#amount');
                    if (response.status) {
                        clearMessage(amountField);
                        $(amountField).addClass('is-valid');
                        $(amountField).closest('div').find(".valid-feedback").html(response.message);
                        amountStatus = true;
                        let base_currency = "{{basicControl()->base_currency}}"
                        showCharge(response, base_currency);
                    } else {
                        amountStatus = false;
                        // submitButton();
                        $('#payoutSummary').html(`<div class="row d-flex text-center justify-content-center">
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                                        <p>@lang('Waiting for payout preview')</p>
                                                    </div>
                                                </div>`);
                        clearMessage(amountField);
                        $(amountField).addClass('is-invalid');
                        $(amountField).closest('div').find(".invalid-feedback").html(response.message);
                    }

                });
            }


            function showCharge(response, currency) {
                let formattedAmount = parseFloat(response.amount).toFixed(2);
                let formattedCharge = parseFloat(response.charge).toFixed(2);
                let formattedAmountInBaseCurrency = parseFloat(response.amount_in_base_currency).toFixed(2);
                let formattedNetAmountInBaseCurrency = parseFloat(response.net_amount_in_base_currency).toFixed(2);

                let txnDetails = `<div class="side-box mt-2">
                    <h5>@lang('Payout Summary')</h5>
                    <div class="showCharge">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ __('Amount In') }} ${response.currency}</span>
                                <span class="text-success">${formattedAmount} ${response.currency}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ __('Charge') }}</span>
                                <span class="text-danger">${formattedCharge} ${response.currency}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ __('Payout Amount') }}</span>
                                <span>${formattedAmountInBaseCurrency} ${currency}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ __('In Base Currency') }}</span>
                                <span>${formattedNetAmountInBaseCurrency} ${currency}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <button type="submit" class="cmn-btn w-100 payoutSubmit">@lang('Withdraw') <span></span></button>`;

                $('#payoutSummary').html(txnDetails);
            }

        });
    </script>
@endpush

