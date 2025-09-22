@extends(template().'layouts.user')
@section('title',trans('Payment Logs'))
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Payment Logs')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payment Logs')</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Payment Logs')</h4>
                <div class="btn-area">
                    <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">@lang('Filter')<i
                            class="fa-regular fa-filter"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive ">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Transaction ID')</th>
                                <th scope="col">@lang('Method')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(count($logs) > 0)
                                @foreach($logs as $log)
                                    <tr>
                                        <td data-label="@lang('Transaction ID')">
                                            <span>{{$log->trx_id}}</span>
                                        </td>
                                        <td data-label="@lang('Method')">
                                            <a class="d-flex align-items-center" href="#">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-sm avatar-circle">
                                                        <img class="avatar-img" src="{{ getFile($log->gateway?->driver,$log->gateway?->image) }}" alt="Image Description">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="text-inherit mb-0 logMethodTitle">{{ $log->gateway?->name }} <i class="bi-patch-check-fill text-primary" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Top endorsed" data-bs-original-title="Top endorsed"></i></h5>
                                                </div>
                                            </a>
                                        </td>
                                        <td data-label="@lang('Amount')" class="name-data">
                                            <span class="name">{{currencyPosition($log->amount_in_base)}}</span>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($log->status == 1)
                                                <span class="badge text-bg-success">@lang('Successful')</span>
                                            @elseif($log->status == 2)
                                                <span class="badge text-bg-secondary">@lang('Pending')</span>
                                            @elseif($log->status == 3)
                                                <span class="badge text-bg-danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Date')">
                                            <span>{{dateTime($log->created_at,basicControl()->date_time_format)}}</span>
                                        </td>
                                        <td data-label="@lang('Action')" class="td-btn">
                                            @php
                                                $details = null;
                                                if ($log->information) {
                                                    $details = [];
                                                    foreach ($log->information as $k => $v) {
                                                        if ($v->type == "file") {
                                                            $details[kebab2Title($k)] = [
                                                                'type' => $v->type,
                                                                'field_name' => $v->field_name,
                                                                'field_value' => getFile(config('filesystems.default'), $v->field_value),
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
                                            @if($log->payment_method_id > 999)
                                                <button type="button" class="action-btn-primary edit_btn"
                                                        data-detailsinfo="{{json_encode($details)}}"
                                                        data-feedback="{{$log->note}}" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal"><i class="fa-regular fa-eye"></i>
                                                    <span></span>
                                                </button>
                                            @else
                                                -
                                            @endif
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
        {{ $logs->appends($_GET)->links(template().'partials.pagination') }}
    </div>

    <!-- user table -->

    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
         aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Payment Log Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.fund.index')}}" method="GET">
                <div class="row g-4">
                    <div>
                        <label for="TransactionID" class="form-label">@lang('Transaction ID')</label>
                        <input type="text" name="trxId" value="{{request()->trxId}}" class="form-control"
                               placeholder="@lang('Transaction ID')">
                    </div>

                    <div>
                        <label for="Amount" class="form-label">@lang('Amount')</label>
                        <input type="number" step="any" value="{{request()->amount}}" name="amount" class="form-control" placeholder="@lang('Amount')">
                    </div>

                    <div id="formModal">
                        <label for="PaymentMethod" class="form-label">@lang('Payment Method')</label>
                        <select class="modal-select" name="gateway_id">
                            <option value="">@lang('All')</option>
                            @if(!empty($gateways))
                                @foreach($gateways as $gateway)
                                    <option value="{{$gateway->id}}" {{request()->gateway_id == $gateway->id ? 'selected':''}}> {{$gateway->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div id="formModal">
                        <label for="Status" class="form-label">@lang('Status')</label>
                        <select class="modal-select" name="status">
                            <option value="">@lang('All')</option>
                            <option
                                value="1" {{request()->status == 1 ? 'selected':''}}>@lang('Successful')</option>
                            <option value="2" {{request()->status == 2 ? 'selected':''}}>@lang('Pending')</option>
                            <option value="3" {{request()->status == 3 ? 'selected':''}}>@lang('Rejected')</option>
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

    <!-- Modal section 2 start -->
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang("Payment Information")</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <ul class="list-group mb-4 payment_information"></ul>
                            <label>@lang('Admin Feedback')</label>
                            <textarea class="form-control" id="feedBack"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal section 2 end -->
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

        $(document).on("click", '.edit_btn', function (e) {
            $('#feedBack').text();
            $('.payment_information').html('');
            let details = Object.entries($(this).data('detailsinfo'));
            let feedback = $(this).data('feedback');
            let list = details.map(([key, value]) => {

                let field_name = value.field_name;
                let field_value = value.field_value;
                let field_name_text = field_name.replace(/_/g, ' ');


                if (value.type === 'file') {
                    return `<li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-capitalize">${field_name_text}</span>
                                        <a href="${field_value}" target="_blank"><img src="${field_value}" alt="Image Description" class="rounded-1" width="100"></a>
                                    </div>
                                </li>`;
                } else {
                    return `<li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-capitalize">${field_name_text}</span>
                                        <span>${field_value}</span>
                                    </div>
                                </li>`;
                }
            })

            $('#feedBack').text(feedback);
            $('.payment_information').html(list);

        });
    </script>
@endpush
