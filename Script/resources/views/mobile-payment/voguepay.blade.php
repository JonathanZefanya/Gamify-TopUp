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
                        <button type="button"
                                class="game-btn"
                                id="btn-confirm">@lang('Pay with VoguePay')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')

    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        let closedFunction = function () {

        }
        let successFunction = function (transaction_id) {
            let txref = "{{ $data->merchant_ref }}";
            window.location.href = '{{ url('payment/voguepay') }}/' + txref + '/' + transaction_id;
        }
        let failedFunction = function (transaction_id) {
            window.location.href = '{{ route('failed') }}';
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo: "{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5cff7398d89d1',
                store_id: "{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed: closedFunction,
                success: successFunction,
                failed: failedFunction
            });
        }


        $(document).on('click', '#btn-confirm', function (e) {
            e.preventDefault();
            pay('Buy', {{ $data->Buy }});
        });

    </script>
@endpush

