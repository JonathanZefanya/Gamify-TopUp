@extends($extends)
@section('title')
    {{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection

@section('content')

    @php
        $containerClass = (str_ends_with($extends, 'user') && auth()->user()->active_dashboard == 'daybreak')
            ? 'container'
            : (str_ends_with($extends, 'user') ? '' : 'main-content');
    @endphp
    <div class="{{ $containerClass }}">
        @if(str_ends_with($extends, 'user') && auth()->user()->active_dashboard == 'daybreak')
            <div class="pagetitle mt-20">
                <h4 class="mb-1">{{ optional($deposit->gateway)->name }}</h4>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">{{ optional($deposit->gateway)->name }}</li>
                    </ol>
                </nav>
            </div>
        @elseif(str_ends_with($extends, 'user') && auth()->user()->active_dashboard == 'nightfall')
            <div class="pagetitle">
                <h3 class="mb-1">{{ optional($deposit->gateway)->name }}</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">{{ optional($deposit->gateway)->name }}</li>
                    </ol>
                </nav>
            </div>
        @endif
        <section class="section">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card card-primary shadow">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-3">
                                    <img
                                        src="{{getFile(optional($deposit->gateway)->driver,optional($deposit->gateway)->image)}}"
                                        class="card-img-top gateway-img">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="my-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
                                    <button class="cmn-btn"
                                            onclick="payWithMonnify()">@lang('Pay Now')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('style')
    <style>
        .main-content{
            background: var(--bg-color1);
        }
    </style>
@endpush
@push('extra_scripts')
    <script type="text/javascript" src="//sdk.monnify.com/plugin/monnify.js"></script>
    <script type="text/javascript">
        'use strict';
        function payWithMonnify() {
            MonnifySDK.initialize({
                amount: {{ $data->amount }},
                currency: "{{ $data->currency }}",
                reference: "{{ $data->ref }}",
                customerName: "{{$data->customer_name }}",
                customerEmail: "{{$data->customer_email }}",
                customerMobileNumber: "{{ $data->customer_phone }}",
                apiKey: "{{ $data->api_key }}",
                contractCode: "{{ $data->contract_code }}",
                paymentDescription: "{{ $data->description }}",
                isTestMode: true,
                onComplete: function (response) {
                    if (response.paymentReference) {
                        window.location.href = '{{ route('ipn', ['monnify', $data->ref]) }}';
                    } else {
                        window.location.href = '{{ route('failed') }}';
                    }
                },
                onClose: function (data) {
                }
            });
        }
    </script>
@endpush
