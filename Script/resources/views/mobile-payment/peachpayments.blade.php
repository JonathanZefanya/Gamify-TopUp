@extends('mobile-payment.layout')
@section('content')
    <section class="pwa-payment-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col h-100 d-flex align-items-center justify-content-center">
                    <div class="pay-box">
                        <div class="d-flex">
                            <div class="img-box">
                                <img
                                    class="img-fluid"
                                    src="{{getFile(optional($deposit->gateway)->driver,optional($deposit->gateway)->image)}}"
                                    alt="..."
                                />
                            </div>
                            <div class="text-box">
                                <h4>@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h4>
                            </div>
                        </div>
                        <form action="{{$data->url}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($data->environment == 'test')
        <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$data->checkoutId}}"></script>
    @else
        <script src="https://oppwa.com/v1/paymentWidgets.js?checkoutId={{$data->checkoutId}}"></script>
    @endif
@endsection
