@extends('admin.layouts.app')
@section('page_title',__('Users Activity'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">@lang('Users Activity')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Users Activity')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Users Activity')</h1>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend input-group-text">
                            <i class="bi-search"></i>
                        </div>
                        <input id="datatableSearch" type="search" class="form-control" placeholder="Search activity"
                               aria-label="Search users" autocomplete="off">
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
                                    <h5 class="card-header-title">@lang('Filter activity')</h5>
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2"
                                            id="filter_close_btn">
                                        <i class="bi-x-lg"></i>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <span class="text-cap text-body">@lang("User")</span>
                                            <input type="text" class="form-control" id="username_filter_input"
                                                   autocomplete="off">
                                        </div>
                                        <div class="col-12 mb-4">
                                            <span class="text-cap text-body">@lang("IP")</span>
                                            <input type="text" class="form-control" id="ip_filter_input"
                                                   autocomplete="off">
                                        </div>
                                        <div class="col-12 mb-4">
                                            <span class="text-cap text-body">@lang("Other")</span>
                                            <input type="text" class="form-control" id="other_filter_input"
                                                   autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" id="filter_button"
                                                class="btn btn-primary">@lang('Apply')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class=" table-responsive datatable-custom  ">
                <table id="datatable"
                       class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                       "columnDefs": [{
                          "targets": [0, 7],
                          "orderable": false
                        }],
                       "order": [],
                       "info": {
                         "totalQty": "#datatableWithPaginationInfoTotalQty"
                       },
                       "search": "#datatableSearch",
                       "entries": "#datatableEntries",
                       "pageLength": 15,
                       "isResponsive": false,
                       "isShowPaging": false,
                       "pagination": "datatablePagination"
                     }'>
                    <thead class="thead-light">
                    <tr>
                        <th>@lang('User')</th>
                        <th>@lang('IP')</th>
                        <th>@lang('City')</th>
                        <th>@lang('Lat - Lon')</th>
                        <th>@lang('Timezone')</th>
                        <th>@lang('Device')</th>
                        <th>@lang('Remark')</th>
                        <th>@lang('Date Time')</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>


            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">@lang('Showing:')</span>
                            <div class="tom-select-custom">
                                <select id="datatableEntries"
                                        class="js-select form-select form-select-borderless w-auto" autocomplete="off"
                                        data-hs-tom-select-options='{
                                            "searchInDropdown": false,
                                            "hideSearch": true
                                          }'>
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">of</span>
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

@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush


@push('js-lib')
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/appear.min.js') }}"></script>
    <script src="{{ asset("assets/admin/js/hs-counter.min.js") }}"></script>
@endpush


@push('script')
    <script>
        $(document).on('ready', function () {

            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route("admin.userActivitySearch") }}",

                },
                columns: [
                    {data: 'user', name: 'user'},
                    {data: 'ip', name: 'ip'},
                    {data: 'city', name: 'city'},
                    {data: 'lat_lon', name: 'lat_lon'},
                    {data: 'timezone', name: 'timezone'},
                    {data: 'browser', name: 'browser'},
                    {data: 'remark', name: 'remark'},
                    {data: 'date', name: 'date'},
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


            $(document).on('click', '#filter_button', function () {
                let filterName = $('#username_filter_input').val();
                let filterIp = $('#ip_filter_input').val();
                let filterOther = $('#other_filter_input').val();

                const datatable = HSCore.components.HSDatatables.getItem(0);

                datatable.ajax.url("{{ route('admin.userActivitySearch') }}" +
                    "?filterName=" + filterName + "&filterIp=" + filterIp + "&filterOther=" +
                    filterOther).load();
            });

            $.fn.dataTable.ext.errMode = 'throw';

            $(document).on('click', '.loginAccount', function () {
                let route = $(this).data('route');
                $('.loginAccountAction').attr('action', route)
            });

            $(document).on('click', '#datatableCheckAll', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });

            $(document).on('click', '.delete-multiple', function (e) {
                e.preventDefault();
                let all_value = [];
                $(".row-tic:checked").each(function () {
                    all_value.push($(this).attr('data-id'));
                });
                let strIds = all_value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.user.delete.multiple') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();
                    },
                });
            });

            $(document).on('click', '.addBalance', function () {
                $('.setBalanceRoute').attr('action', $(this).data('route'));
                $('.user-balance').text($(this).data('balance'));
            })


        });

    </script>

@endpush




