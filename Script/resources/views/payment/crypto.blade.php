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
                        <div class="card-header">@lang('Payment Preview')</div>
                        <div class="card-body text-center">
                            <h4 class="text-color"> @lang('PLEASE SEND EXACTLY') <span
                                    class="text-success"> {{ getAmount($data->amount) }}</span> {{ __($data->currency) }}
                            </h4>
                            <h5>@lang('TO') <span class="text-success"> {{ __($data->sendto) }}</span></h5>
                            <img src="{{ $data->img }}">
                            <h4 class="text-color bold">@lang('SCAN TO SEND')</h4>
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

