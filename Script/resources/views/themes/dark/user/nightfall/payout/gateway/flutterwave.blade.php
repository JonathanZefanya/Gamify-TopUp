@extends(template().'layouts.user')
@section('title',__('Payout'))

@section('content')
    <div class="pagetitle mt-20">
        <h4 class="mb-1">@lang('Flutterwave Payouts')</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Flutterwave Payouts')</li>
            </ol>
        </nav>
    </div>
    <div class="row gy-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body gradient-bg">
                    <form action="{{ route('user.payout.flutterwave',$payout->trx_id) }}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="type" name="type" value="">
                        <div class="row g-4">
                            @if($payoutMethod->supported_currency)
                                <div class="col-md-12">
                                    <label for="from_wallet" class="mb-3">@lang('Select Bank Currency')</label>
                                    <div class="input-box search-currency-dropdown">
                                        <input type="text" name="currency_code"
                                               placeholder="@lang('Selected')"
                                               autocomplete="off"
                                               value="{{ $payout->payout_currency_code }}"
                                               class="form-control transfer-currency @error('currency_code') is-invalid @enderror">

                                        @error('currency_code')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <label for="from_wallet">@lang('Select Transfer')</label>
                            <div class="col-md-12 input-box mt-2">
                                <select id="from_wallet" name="transfer_name"
                                        class="form-control form-control-sm bank">
                                    <option value="" disabled=""
                                            selected="">@lang('Select Transfer')</option>
                                    @foreach($payoutMethod->banks as $bank)
                                        <option
                                            value="{{$bank}}" {{old('transfer_name') == $bank ?'selected':''}}>{{$bank}}</option>
                                    @endforeach
                                </select>
                                @error('transfer_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-12  dynamic-bank mx-1 d-none mt-3">
                                <label class="mb-2 d-block">@lang('Select Bank')</label>
                                <select id="dynamic-bank" name="bank"
                                        class="form-control js-example-basic-single d-block">
                                </select>
                                @error('bank')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="row dynamic-input mt-4">

                            </div>

                            @if($payoutMethod->automatic_payout_permisstion)
                                <div class="input-box mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="automatic_payout_permisstion"
                                               type="checkbox" value="1"/>
                                        <label class="form-check-label" for="tandc">
                                            @lang('Automatic Payout')
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div class="input-box col-12">
                                <button type="submit" class="cmn-btn">@lang('submit') <span></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card bg-gradient contact-box">
                <div class="card-body gradient-bg">
                    <ul class="list-group list-group-numbered">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Payout Method')</div>
                            </div>
                            <span class="">{{ __($payoutMethod->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Request Amount')</div>

                            </div>
                            <span
                                class=" ">{{ (getAmount($payout->amount)) }} {{ $payout->payout_currency_code }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Charge')</div>
                            </div>
                            <span
                                class="text-danger">{{ (getAmount($payout->charge)) }} {{ $payout->payout_currency_code }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Amount In Base Currency')</div>
                            </div>
                            <span
                                class=" ">{{ (getAmount($payout->amount_in_base_currency)) }} {{ basicControl()->base_currency }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script type="text/javascript">
        'use strict';

        var bankName = null;
        var payAmount = '{{$payout->amount}}';
        var baseCurrency = "{{basicControl()->base_currency}}";
        var transferName = "{{old('transfer_name')}}";
        if (transferName) {
            getBankForm(transferName);
        }


        $(document).ready(function () {
            $(document).on("change", ".bank", function () {
                bankName = $(this).val();
                $('.dynamic-bank').addClass('d-none');
                getBankForm(bankName);
            })
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getBankForm(bankName) {
            $.ajax({
                url: "{{route('user.payout.getBankForm')}}",
                type: "post",
                data: {
                    bankName,
                },
                success: function (response) {
                    if (response.bank != null) {
                        showBank(response.bank.data)
                    }
                    showInputForm(response.input_form)
                }
            });
        }

        function showBank(bankLists) {
            $('#dynamic-bank').html(``);
            var options = `<option disabled selected>@lang("Select Bank")</option>`;
            for (let i = 0; i < bankLists.length; i++) {
                options += `<option value="${bankLists[i].code}">${bankLists[i].name}</option>`;
            }

            $('.dynamic-bank').removeClass('d-none');
            $('#dynamic-bank').html(options);
        }

        function showInputForm(form_fields) {
            $('.dynamic-input').html(``);
            var output = "";

            for (let field in form_fields) {
                let newKey = field.replace('_', ' ');
                output += `<div class="col-md-6 mt-3">
                         <label>${newKey}</label>
				         <input type="text" name="${field}" value="" class="form-control" required>
			          </div>`
            }
            $('.dynamic-input').html(output);
        }

    </script>

@endpush
