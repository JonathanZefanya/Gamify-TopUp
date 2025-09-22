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
            <div class="row g-4 justify-content-center">
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
                                    <button type="button"
                                            class="btn cmn-btn"
                                            id="pay-button">@lang('Pay Now')
                                    </button>
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

@push('script')
    @if($data->environment == 'test')
        <script type="text/javascript"
                src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ $data->client_key }}"></script>
    @else
        <script type="text/javascript"
                src="https://app.midtrans.com/snap/snap.js"
                data-client-key="{{ $data->client_key }}"></script>
    @endif
    <script defer>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay("{{ $data->token }}", {
                onSuccess: function (result) {
                    let route = '{{ route('ipn', ['midtrans']) }}/';
                    window.location.href = route + result.order_id;
                },
                onPending: function (result) {
                    let route = '{{ route('ipn', ['midtrans']) }}/';
                    window.location.href = route + result.order_id;
                },
                onError: function (result) {
                    window.location.href = '{{ route('failed') }}';
                },
                onClose: function () {
                    window.location.href = '{{ route('failed') }}';
                }
            });
        });
    </script>
@endpush



