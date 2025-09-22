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
                                <h4>@lang('Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h4>
                            </div>
                        </div>
                        <button type="button" class="btn-custom w-100" id="payment-button">@lang('Pay with Khalti')</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script
        src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script>

        $(document).ready(function () {
            $('body').addClass('antialiased')
        });

        var config = {
            // replace the publicKey with yours
            "publicKey": "{{$data->publicKey}}",
            "productIdentity": "{{$data->productIdentity}}",
            "productName": "Payment",
            "productUrl": "{{url('/')}}",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
            ],
            "eventHandler": {
                onSuccess(payload) {
                    // hit merchant api for initiating verfication
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('khalti.verifyPayment',[$deposit->trx_id]) }}",
                        data: {
                            token: payload.token,
                            amount: payload.amount,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (res) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('khalti.storePayment') }}",
                                data: {
                                    response: res,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function (res) {
                                    window.location.href = "{{route('success')}}"
                                }
                            });
                        }
                    });
                },
                onError(error) {
                },
                onClose() {
                }
            }
        };
        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({amount: "{{$data->amount *100}}"});
        }
    </script>
@endpush
