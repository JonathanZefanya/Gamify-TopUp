@extends(template().'layouts.user')
@section('title',trans('Transactions'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Transactions')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Transactions')</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-0 border-0">
            <h4>@lang('Transactions')</h4>
            <div class="btn-area">
                <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">@lang('Filter')<i
                        class="fa-regular fa-filter"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="cmn-table">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                        <tr>
                            <th scope="col">@lang('Transaction ID')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Type')</th>
                            <th scope="col">@lang('Remark')</th>
                            <th scope="col">@lang('Date')</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(count($transactions) > 0)
                            @foreach($transactions as $log)
                                <tr>
                                    <td data-label="@lang('Transaction ID')">
                                        <span>{{$log->trx_id}}</span>
                                    </td>
                                    <td data-label="@lang('Amount')" class="name-data">
                                        @if($log->trx_type == '-')
                                            <span
                                                class="text-danger">{{$log->trx_type}}{{CurrencyPosition($log->amount_in_base)}}</span>
                                        @else
                                            <span
                                                class="text-success">{{$log->trx_type}}{{CurrencyPosition($log->amount_in_base)}}</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Type')">
                                        @if($log->transactional_type == \App\Models\Deposit::class)
                                            <span>@lang('Deposit')</span>
                                        @elseif($log->transactional_type == \App\Models\Order::class)
                                            <span>@lang('Order')</span>
                                        @elseif($log->transactional_type == \App\Models\Payout::class)
                                            <span>@lang('Payout')</span>
                                        @elseif($log->transactional_type == \App\Models\SellPostPayment::class)
                                            <span>@lang('Sell Post')</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-label="@lang('Remark')">
                                        <span>{{$log->remarks}}</span>
                                    </td>
                                    <td data-label="@lang('Date')">
                                        <span>{{dateTime($log->created_at,basicControl()->date_time_format)}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @include('empty')
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    {{ $transactions->appends($_GET)->links(template().'partials.pagination') }}
    <!-- user table -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
         aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Transaction Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.transaction')}}" method="GET">
                <div class="row g-4">
                    <div>
                        <label for="TransactionID" class="form-label">@lang('Transaction ID')</label>
                        <input type="text" name="trxId" value="{{request()->trxId}}" class="form-control"
                               placeholder="@lang('Transaction ID')">
                    </div>

                    <div>
                        <label for="Amount" class="form-label">@lang('Amount')</label>
                        <input type="number" step="any" value="{{request()->amount}}" name="amount"
                               class="form-control"
                               placeholder="@lang('Amount')">
                    </div>
                    <div>
                        <label for="Amount" class="form-label">@lang('Remark')</label>
                        <input type="text" value="{{request()->remark}}" name="remark"
                               class="form-control"
                               placeholder="@lang('Remark')">
                    </div>

                    <div id="formModal">
                        <label for="Type" class="form-label">@lang('Type')</label>
                        <select class="modal-select" name="type">
                            <option value="">@lang('All')</option>
                            <option value="deposit" {{request()->status == 'deposit' ? 'selected':''}}>@lang('Deposit')</option>
                            <option value="order" {{request()->status == 'order' ? 'selected':''}}>@lang('Order')</option>
                            <option value="payout" {{request()->status == 'payout' ? 'selected':''}}>@lang('Payout')</option>
                            <option value="sellPost" {{request()->status == 'sellPost' ? 'selected':''}}>@lang('Sell Post')</option>
                        </select>
                    </div>

                    <div>
                        <label for="Date" class="form-label">@lang('Date')</label>
                        <input type="date" name="created_at" class="form-control" id="date">
                    </div>

                    <button type="submit" class="cmn-btn">@lang('Search')<span></span></button>
                </div>
            </form>
        </div>
    </div>
    <!-- offcanvas -->
@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{asset('assets/global/css/flatpickr.min.css')}}">
@endpush
@push('js-lib')
    <script src="{{asset('assets/global/js/flatpickr.min.js')}}"></script>
@endpush
@push('script')
    <script>
        'use strict';
        flatpickr("#date");
    </script>
@endpush
