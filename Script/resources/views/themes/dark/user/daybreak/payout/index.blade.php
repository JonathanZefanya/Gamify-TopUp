@extends(template().'layouts.user')
@section('title','Payout History')
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Payouts')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payouts')</li>
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
                                <th scope="col">@lang('Trx ID')</th>
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Amount (In Base)')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Time')</th>
                                <th scope="col">@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($payouts as $key => $item)
                                <tr>
                                    <td data-label="#@lang('Trx ID')">{{$item->trx_id}}</td>
                                    <td data-label="@lang('Gateway')" class="d-initial">
                                        <span><img class="pay-meth-img" src="{{ getFile(optional($item->method)->driver, optional($item->method)->logo) }}"></span>
                                        <span>@lang(optional($item->method)->name)</span>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        {{ (getAmount($item->amount)).' '.$item->payout_currency_code }}
                                    </td>
                                    <td data-label="@lang('Amount (In Base)')">
                                        {{ currencyPosition($item->amount_in_base_currency)}}
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status == 1)
                                            <span class="badge text-bg-warning">@lang('Pending')</span>
                                        @elseif($item->status == 2)
                                            <span class="badge text-bg-success">@lang('Complete')</span>
                                        @elseif($item->status == 3)
                                            <span class="badge text-bg-danger">@lang('Cancel')</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Time')">
                                        {{ dateTime($item->created_at, 'd M Y h:i A') }}
                                    </td>
                                    <td data-label="@lang('Detail')">
                                        @php
                                            $details = null;
                                            if ($item->information) {
                                                $details = [];
                                                foreach ($item->information as $k => $v) {
                                                    if ($v->type == "file") {
                                                        $details[kebab2Title($k)] = [
                                                            'type' => $v->type,
                                                            'field_name' => $v->field_name,
                                                            'field_value' => getFile('local', $v->field_value),
                                                        ];
                                                    } else {
                                                        $details[kebab2Title($k)] = [
                                                            'type' => $v->type,
                                                            'field_name' => $v->field_name,
                                                            'field_value' => @$v->field_value ?? $v->field_name
                                                        ];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <button type="button" class="action-btn-primary btn-icon infoButton "
                                                data-information="{{json_encode($details)}}"
                                                data-feedback="{{$item->feedback}}"
                                                data-trx_id="{{ $item->trx_id }}"><i
                                                class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <div class="text-center">
                                    @include('empty')
                                </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        {{ $payouts->appends($_GET)->links(template().'partials.pagination') }}
    </div>
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
            <form action="{{ route('user.payout.index') }}" method="GET">
                <div class="row g-4">
                    <div>
                        <label for="TransactionID" class="form-label">@lang('Name')</label>
                        <input type="text" name="name" value="{{@request()->name}}"
                               class="form-control"
                               placeholder="@lang('Type Here')">
                    </div>

                    <div id="formModal">
                        <label for="Type" class="form-label">@lang('Type')</label>
                        <select class="modal-select" name="status">
                            <option value="">@lang('All Payment')</option>
                            <option value="1"
                                    @if(@request()->status == '1') selected @endif>@lang('Pending Payment')</option>
                            <option value="2"
                                    @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                            <option value="3"
                                    @if(@request()->status == '3') selected @endif>@lang('Rejected Payment')</option>
                        </select>
                    </div>

                    <div>
                        <label for="Date" class="form-label">@lang('Date')</label>
                        <input type="date" class="form-control" name="date_time"
                               id="date"/>
                    </div>

                    <button type="submit" class="cmn-btn">@lang('Search')<span></span></button>
                </div>
            </form>
        </div>
    </div>

    <div id="infoModal" class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-custom">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa-regular fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group ">
                        <li class="list-group-item">@lang('Transactions') : <span class="trx"></span></li>
                        <li class="list-group-item">@lang('Admin Feedback') : <span class="feedback"></span></li>
                    </ul>
                    <div class="payout-detail">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeModal"
                            data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas -->
@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{asset('assets/global/css/flatpickr.min.css')}}">
    <style>
        li.list-group-item.bg-transparent {
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .payout-detail strong{
            display: block;
            margin-bottom: 10px !important;
        }
        .payoutImage{
            height: 100px;
            width: 100px;
            border-radius: 10px;
        }
        .pay-meth-img{
            height: 40px;
            width: 40px;
            border-radius: 50%;
        }

    </style>
@endpush
@push('js-lib')
    <script src="{{asset('assets/global/js/flatpickr.min.js')}}"></script>
@endpush
@push('script')
    <script>
        'use strict';
        flatpickr("#date");

        $(document).ready(function () {
            $('.infoButton').on('click', function () {
                var infoModal = $('#infoModal');
                infoModal.find('.trx').text($(this).data('trx_id'));
                infoModal.find('.feedback').text($(this).data('feedback'));
                var list = [];
                var information = Object.entries($(this).data('information'));
                var result = ``;
                for (var i = 0; i < information.length; i++) {

                    if (information[i][1].type == 'file') {
                        result += `<li class="list-group-item bg-transparent">
                                            <span><span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : </span> <img class="payoutImage"src="${information[i][1].field_value ?? information[i][1].field_name}" alt="..." class="w-100">
                                        </li>`;
                    } else {
                        result += `<li class="list-group-item bg-transparent">
                                            <span><span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> :</span> <span class="font-weight-bold ml-3">${information[i][1].field_value ?? information[i][1].field_name}</span>
                                        </li>`;
                    }
                }

                if (result) {
                    infoModal.find('.payout-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${result}`);
                } else {
                    infoModal.find('.payout-detail').html(`${result}`);
                }
                infoModal.modal('show');
            });


            $('.closeModal').on('click', function (e) {
                $("#infoModal").modal("hide");
            });
        });
    </script>
@endpush
