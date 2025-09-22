@extends($extends)
@section('title', __('Pay with PAYPAL'))
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
                            <div id="paypal-button-container"></div>
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
    <script src="https://www.paypal.com/sdk/js?client-id={{ $data->cleint_id }}">
    </script>
    <script>
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [
                        {
                            description: "{{ $data->description }}",
                            custom_id: "{{ $data->custom_id }}",
                            amount: {
                                currency_code: "{{ $data->currency }}",
                                value: "{{ $data->amount }}",
                                breakdown: {
                                    item_total: {
                                        currency_code: "{{ $data->currency }}",
                                        value: "{{ $data->amount }}"
                                    }
                                }
                            }
                        }
                    ]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    var trx = "{{ $data->custom_id }}";
                    window.location = '{{ url('payment/paypal')}}/' + trx + '/' + details.id
                });
            }
        }).render('#paypal-button-container');
    </script>
@endpush
