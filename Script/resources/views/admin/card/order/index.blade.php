@extends('admin.layouts.app')
@section('page_title','Card Orders')
@section('content')
    <div class="content container-fluid">
        <x-page-header menu="Card Order" :statBtn="true"/>

        <div class="row d-none" id="statsSection">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Pending Orders")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$orders['pendingOrder']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">@lang("From") {{$orders['totalOrder']??0}}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-warning text-warning p-1">
                                <i class="bi-graph-up"></i> {{fractionNumber($orders['pendingOrderPercentage'])??0}}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Complete Orders")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$orders['completeOrder']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">@lang("From") {{$orders['totalOrder']??0}}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-danger text-danger p-1">
                                <i class="bi-graph-up"></i> {{fractionNumber($orders['completeOrderPercentage'])??0}}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Refund Orders")</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$orders['refundOrder']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">@lang("From") {{$orders['totalOrder']??0}}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-info text-info p-1">
                                <i class="bi-graph-down"></i> {{$orders['refundOrderPercentage']??0}}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Today Orders")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$orders['todayOrder']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">from {{$orders['totalOrder']??0}}</span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-soft-success text-success p-1">{{fractionNumber($orders['todayOrderPercentage'])??0}}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header card-header-content-md-between">
                        <div class="mb-2 mb-md-0">
                            <div class="input-group input-group-merge navbar-input-group">
                                <div class="input-group-prepend input-group-text">
                                    <i class="bi-search"></i>
                                </div>
                                <input type="search" id="datatableSearch"
                                       class="search form-control form-control-sm"
                                       placeholder="@lang('Search Order')"
                                       aria-label="@lang('Search Order')"
                                       autocomplete="off">
                                <a class="input-group-append input-group-text" href="javascript:void(0)">
                                    <i id="clearSearchResultsIcon" class="bi-x d-none"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                            <div class="dropdown">
                                <button type="button" class="btn btn-white btn-sm w-100"
                                        id="dropdownMenuClickable" data-bs-auto-close="false"
                                        id="usersFilterDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi-filter me-1"></i> @lang('Filter')
                                </button>

                                <div
                                    class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered filter_dropdown"
                                    aria-labelledby="dropdownMenuClickable">
                                    <div class="card">
                                        <div class="card-header card-header-content-between">
                                            <h5 class="card-header-title">@lang('Filter')</h5>
                                            <button type="button"
                                                    class="btn btn-ghost-secondary btn-icon btn-sm ms-2"
                                                    id="filter_close_btn">
                                                <i class="bi-x-lg"></i>
                                            </button>
                                        </div>

                                        <div class="card-body">
                                            <form id="filter_form">
                                                <div class="mb-4">
                                                            <span
                                                                class="text-cap text-body">@lang('Order Id')</span>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="text" class="form-control"
                                                                   id="name_filter_input"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                            <span
                                                                class="text-cap text-body">@lang('Service')</span>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="text" class="form-control"
                                                                   id="service_filter_input"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">@lang('Status')</small>
                                                        <div class="tom-select-custom">
                                                            <select
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                id="filter_status"
                                                                data-target-column-index="4" data-hs-tom-select-options='{
                                                                  "placeholder": "Any status",
                                                                  "searchInDropdown": false,
                                                                  "hideSearch": true,
                                                                  "dropdownWidth": "10rem"
                                                                }'>
                                                                <option value="all"
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-info"></span>All Status</span>'>
                                                                </option>
                                                                <option value="0"
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-warning"></span>Pending</span>'>
                                                                </option>
                                                                <option value="1"
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Complete</span>'>
                                                                </option>
                                                                <option value="2"
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-secondary"></span>Refund</span>'>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 mb-4">
                                                        <span class="text-cap text-body">@lang('Date Range')</span>
                                                        <div class="input-group mb-3 custom">
                                                            <input type="text" id="filter_date_range"
                                                                   class="js-flatpickr form-control"
                                                                   placeholder="Select dates"
                                                                   data-hs-flatpickr-options='{
                                                                 "dateFormat": "d/m/Y",
                                                                 "mode": "range"
                                                               }' aria-describedby="flatpickr_filter_date_range">
                                                            <span class="input-group-text"
                                                                  id="flatpickr_filter_date_range">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </span>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row gx-2">
                                                    <div class="col">
                                                        <div class="d-grid">
                                                            <button type="button" id="clear_filter"
                                                                    class="btn btn-white">@lang('Clear Filters')</button>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="d-grid">
                                                            <button type="button" class="btn btn-primary"
                                                                    id="filter_button"><i
                                                                    class="bi-search"></i> @lang('Apply')</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" table-responsive datatable-custom">
                        <table id="datatable"
                               class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                       "columnDefs": [{
                                          "targets": [0, 7],
                                          "orderable": false
                                        }],
                                        "ordering": false,
                                       "order": [],
                                       "info": {
                                         "totalQty": "#datatableWithPaginationInfoTotalQty"
                                       },
                                       "search": "#datatableSearch",
                                       "entries": "#datatableEntries",
                                       "pageLength": 20,
                                       "isResponsive": false,
                                       "isShowPaging": false,
                                       "pagination": "datatablePagination"
                                     }'>
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">@lang('Order Id')</th>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Order Product')</th>
                                <th scope="col">@lang('Total Amount')</th>
                                <th scope="col">@lang('Payment Method')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="card-footer">
                        <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div
                                    class="d-flex justify-content-center justify-content-sm-start align-items-center">
                                    <span class="me-2">@lang('Showing:')</span>
                                    <div class="tom-select-custom">
                                        <select id="datatableEntries"
                                                class="js-select form-select form-select-borderless w-auto"
                                                autocomplete="off"
                                                data-hs-tom-select-options='{
                                                        "searchInDropdown": false,
                                                        "hideSearch": true
                                                      }'>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20" selected>20</option>
                                            <option value="30">30</option>
                                        </select>
                                    </div>
                                    <span class="text-secondary me-2">@lang('of')</span>
                                    <span id="datatableWithPaginationInfoTotalQty"></span>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex  justify-content-center justify-content-sm-end">
                                    <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="orderStep" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalHeader">@lang('Delete Confirmation!')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="ModalBody">@lang('Are you certain you want to proceed with the deletion?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="ModalRoute">
                        @csrf
                        <input type="hidden" name="orderId" value="">
                        <button type="submit" class="btn btn-soft-success" id="yesBtn">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="sellAll" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">@lang('Order Products')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="showAll">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        var currency = "{{basicControl()->currency_symbol}}";
        $(document).on("click", ".seeAll", function () {
            let details = $(this).data('detail');
            $('#showAll').html('');
            let show = "";
            details.forEach(detail => {
                show += `<div class="d-flex mb-5">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-xl">
                                            <img class="img-fluid" src="${detail.image_path}" alt="Image Description">
                                        </div>
                                    </div>

                                    <div class="flex-grow-1 ms-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <a class="h5 d-block">${detail.name}</a>

                                                <div class="fs-6 text-body">
                                                    <span>Category:</span>
                                                    <span class="fw-semibold">${detail.detailable.card.name}</span>
                                                </div>
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                <h5>${currency}${(detail.price - detail.discount).toFixed(2)}</h5>
                                            </div>

                                            <div class="col col-md-2 align-self-center">
                                                <h5>${detail.qty}</h5>
                                            </div>

                                            <div class="col col-md-2 align-self-center text-end">
                                                <h5>${currency}${((detail.price - detail.discount) * detail.qty).toFixed(2)}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
            });

            $('#showAll').html(show);
        });

        $(document).on("click", ".actionBtn", function () {
            if ($(this).data('type') === 'complete') {
                $('#ModalHeader').html(`<i class="fas fa-check"></i> Complete Confirmation`);
                $('#ModalBody').text('Are you certain you want to proceed with the completion?');
                $('#yesBtn').addClass('btn btn-soft-success');
            } else {
                $('#ModalHeader').html(`<i class="fas fa-close"></i> Cancel Confirmation`);
                $('#ModalBody').text('Are you certain you want to proceed with the cancellation?');
                $('#yesBtn').addClass('btn btn-soft-danger');
            }
            $('input[name="orderId"]').val($(this).data('id'));
            $('.ModalRoute').attr('action', $(this).data('route'));
        });

        $(document).on('ready', function () {
            new HSFileAttach('.js-file-attach')
            HSCore.components.HSFlatpickr.init('.js-flatpickr')
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250,
            })

            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route("admin.orderCard.listSearch").'?type='.$status }}",
                },

                columns: [
                    {data: 'order', name: 'order'},
                    {data: 'date', name: 'date'},
                    {data: 'card', name: 'card'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'payment_method', name: 'payment_method'},
                    {data: 'user', name: 'user'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ],

                language: {
                    zeroRecords: `<div class="text-center p-4">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`,
                    processing: `<div><div></div><div></div><div></div><div></div></div>`
                },
            })

            document.getElementById("filter_button").addEventListener("click", function () {
                let name = $('#name_filter_input').val();
                let service = $('#service_filter_input').val();
                let filterStatus = $('#filter_status').val();
                let filterDate = $('#filter_date_range').val();

                const datatable = HSCore.components.HSDatatables.getItem(0);
                datatable.ajax.url("{{ route("admin.orderCard.listSearch") }}" + "?type=" + "{{$status}}" + "&name=" + name +
                    "&service=" + service +"&filterDate=" + filterDate + "&filterStatus=" + filterStatus).load();
            });

            $.fn.dataTable.ext.errMode = 'throw';
            $(document).on('click', '#datatableCheckAll', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif

@endpush
