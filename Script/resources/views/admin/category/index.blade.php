@extends('admin.layouts.app')
@section('page_title',$pageTitle)
@section('content')
    <div class="content container-fluid">

        <x-page-header menu="Categories" :statBtn="true"/>

        <div class="row d-none" id="statsSection">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Active Category")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$categories['activeCategory']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">@lang("From") {{$categories['totalCategory']??0}}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-warning text-warning p-1">
                                <i class="bi-graph-up"></i> {{fractionNumber($categories['activeCategoryPercentage'])??0}}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("InActive Category")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$categories['inActiveCategory']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">@lang("From") {{$categories['totalCategory']??0}}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-danger text-danger p-1">
                                <i class="bi-graph-up"></i> {{fractionNumber($categories['inActiveCategoryPercentage'])??0}}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Today Created Category")</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$categories['todayCategory']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">@lang("From") {{$categories['totalCategory']??0}}</span>
                            </div>
                            <div class="col-auto">
                              <span class="badge bg-soft-info text-info p-1">
                                <i class="bi-graph-down"></i> {{$categories['todayCategoryPercentage']??0}}%
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("This Month Created Category")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span
                                    class="js-counter display-4 text-dark">{{$categories['thisMonthCategory']??0}}</span>
                                <span
                                    class="text-body fs-5 ms-1">from {{$categories['totalCategory']??0}}</span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-soft-success text-success p-1">{{fractionNumber($categories['thisMonthCategoryPercentage'])??0}}%</span>
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
                                       placeholder="@lang('Search Category')"
                                       aria-label="@lang('Search Category')"
                                       autocomplete="off">
                                <a class="input-group-append input-group-text" href="javascript:void(0)">
                                    <i id="clearSearchResultsIcon" class="bi-x d-none"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" data-bs-target="#createModal"
                               data-bs-toggle="modal">
                                <i class="fas fa-tags me-1"></i> @lang('Create Category')
                            </a>
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
                                                                class="text-cap text-body">@lang('Category Name')</span>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="text" class="form-control"
                                                                   id="name_filter_input"
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
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-secondary"></span>All Status</span>'>
                                                                </option>
                                                                <option value="1"
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>'>
                                                                </option>
                                                                <option value="0"
                                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Inactive</span>'>
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
                                          "targets": [0, 4],
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
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Active Child')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>

                            <tbody class="js-sortable" data-hs-sortable-options='{
                              "animation": 150,
                              "handle": ".sortablejs-custom-handle"
                            }'>

                            </tbody>
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
    @include('admin.category.create-edit-modal')
    @include('admin.delete-modal')
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
    <script src="{{ asset('assets/admin/js/sortable.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).on('click', '.delete_btn', function () {
            let route = $(this).data('route');
            $('#deleteModalBody').text('Are you sure you want to proceed with the deletion of this category?');
            $('.deleteModalRoute').attr('action', route);
        });

        $(document).on('click', '.edit_btn', function () {
            $('.editRoute').attr('action', $(this).data('route'));
            $('.editName').val($(this).data('name'));
            $('.editIcon').val($(this).data('icon'));
        });


        $(document).on('ready', function () {
            new HSFileAttach('.js-file-attach')
            HSCore.components.HSSortable.init('.js-sortable')
            HSCore.components.HSFlatpickr.init('.js-flatpickr')
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250,
            })

            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route("admin.categoryListSearch").'?type='.$type }}",
                },

                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'active_service', name: 'active_service'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
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

            $('.js-sortable').on('change', function () {
                let methods = [];
                $('.sortable').each(function (key, val) {
                    let methodCode = $(val).data('id');
                    methods.push(methodCode);
                });
                $.ajax({
                    'url': "{{ route('admin.categorySort') }}",
                    'method': "POST",
                    'data': {sort: methods}
                })
            })

            document.getElementById("filter_button").addEventListener("click", function () {
                let name = $('#name_filter_input').val();
                let filterStatus = $('#filter_status').val();
                let filterDate = $('#filter_date_range').val();

                const datatable = HSCore.components.HSDatatables.getItem(0);
                datatable.ajax.url("{{ route("admin.categoryListSearch") }}" + "?type=" + "{{$type}}" + "&name=" + name +
                    "&filterDate=" + filterDate + "&filterStatus=" + filterStatus).load();
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
