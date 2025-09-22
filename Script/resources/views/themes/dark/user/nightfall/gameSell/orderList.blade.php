@extends(template().'layouts.user')
@section('title')
    @lang('Sell Post Order')
@endsection
@section('content')
    <div class="pagetitle mt-20">
        <h4 class="mb-1">@lang('Sell Post Order')</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Sell Post Order')</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-0 border-0">
            <h4>@lang('Sell Posts')</h4>
            <div class="btn-area">
                <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                        class="fa-regular fa-filter"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="cmn-table">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th scope="col">@lang('No.')</th>
                                <th scope="col">@lang('TRX')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Date - Time')</th>
                                <th scope="col">@lang('More')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sellPostOrders as $k => $row)
                                <tr>
                                    <td data-label="@lang('No.')">{{++$k}}</td>
                                    <td data-label="@lang('TRX')">@lang($row->transaction)</td>
                                    <td data-label="@lang('Category')">@lang(optional(optional(optional($row->sellPost)->category)->details)->name)</td>
                                    <td data-label="@lang('Title')">@lang(optional($row->sellPost)->title)</td>
                                    <td data-label="@lang('Amount')">{{currencyPosition($row->price)}}
                                        @if(0 <$row->discount)
                                            <sup
                                                class="badge-light badge-pill "> {{currencyPosition($row->discount)}} @lang('Off')</sup>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Date - Time')">{{dateTime($row->created_at, 'd M, Y h:i A')}}</td>
                                    <td data-label="@lang('More')">
                                        @php
                                            $details = ($row->sellPost->credential != null) ? json_encode($row->sellPost->credential) : null;
                                        @endphp
                                        <button type="button" class="btn btn-custom btn-icon edit_button"
                                                data-bs-toggle="modal" data-bs-target="#credentialShow"
                                                data-info="{{$details}}"
                                                data-id=""
                                        >
                                            <i class="fa fa-eye text-light eye_button"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="9">@lang('No Data Found')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $sellPostOrders->appends($_GET)->links(template().'partials.pagination') }}
            </div>
        </div>
    </div>


    <!-- Modal for Code Show -->
    <div class="modal fade" id="credentialShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-custom">
                    <h4 class="modal-title" id="myModalLabel">@lang('Credentials')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body">
                    <div class="withdraw-detail">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Sell Post Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.sellList')}}" method="get">
                <div class="row g-4">
                    <div>
                        <label for="ProductName" class="form-label">@lang('Transaction Id')</label>
                        <input type="text" name="transaction_id" value="{{@request()->transaction_id}}" class="form-control"
                               placeholder="@lang('Search for Transaction ID')">
                    </div>
                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Date')</label>
                        <input type="date" name="datetrx" class="form-control" value="{{@request()->date}}" id="date" placeholder="@lang('Select Date')">
                    </div>

                    <div class="btn-area">
                        <button type="submit" class="cmn-btn">@lang('Filter')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
@push('style')
    <link rel="stylesheet" href="{{asset('assets/global/css/flatpickr.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <style>
        .copy-btn{
            border: 1px solid var(--bg-color3);
            height: 46px;
            border-radius: 0 5px 5px 0;
        }
    </style>
@endpush

@push('script')
    <script src="{{asset('assets/global/js/flatpickr.min.js')}}"></script>
    <script>
        "use strict";
        flatpickr("#date", {
            theme: "dark"
        });
        $(document).ready(function () {
            $(document).on("click", '.edit_button', function (e) {

                var details = Object.entries($(this).data('info'));
                var list = [];
                details.map(function (item, i) {
                    list[i] = `<div class="form-group">
                                 <label>${item[1].field_name}</label>
                                 <div class="input-group mb-3 ">
                                     <input type="text" id="codeVisible_${i}" class="form-control copyText" value=${item[1].field_value} readonly />
                                    <div class="input-group-append">
                                        <button class="btn btn-custom text-white copy-btn" data-id=${i} data-code=${item[1]} type="button"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                                </div>`
                });

                $('.withdraw-detail').html(list);
            });

            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                console.log(copyText);
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });
        });
    </script>
@endpush
