@extends($extends)
@section('title')
    {{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@push('css-lib')
    <link href="{{ asset('assets/global/css/card-js.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
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
                                        src="{{ getFile(optional($deposit->gateway)->driver, optional($deposit->gateway)->image) }}"
                                        class="card-img-top gateway-img">
                                </div>
                                <div class="col-md-6">
                                    <form class="form-horizontal" id="example-form"
                                          action="{{ route('ipn', [optional($deposit->gateway)->code ?? '', $deposit->trx_id]) }}"
                                          method="post">
                                        <fieldset>
                                            <legend>@lang('Your Card Information')</legend>
                                            <div class="card-js form-group">
                                                <input class="card-number form-control" name="card_number"
                                                       placeholder="@lang('Enter your card number')" autocomplete="off"
                                                       required>
                                                <input class="name form-control" id="the-card-name-id" name="card_name"
                                                       placeholder="@lang('Enter the name on your card')"
                                                       autocomplete="off"
                                                       required>
                                                <input class="expiry form-control" autocomplete="off" required>
                                                <input class="expiry-month form-control" name="expiry_month">
                                                <input class="expiry-yea form-control" name="expiry_year">
                                                <input class="cvc form-control" name="card_cvc" autocomplete="off"
                                                       required>
                                            </div>
                                            <button type="submit" class="cmn-btn">@lang('Submit')</button>
                                        </fieldset>
                                    </form>
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
    <script src="{{ asset('assets/global/js/card-js.min.js') }}"></script>
@endpush
