@extends('admin.layouts.app')
@section('page_title', __('Coupon List'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Coupon List')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang('Coupon List')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Coupon List')</h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('admin.couponStore') }}">
                        <i class="fa-light fa-plus-circle me-1"></i> @lang('Create Coupon')
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12 col-md">
                        <h3 class="page-header-title">@lang('Coupon List')</h3>
                    </div>
                    <div class="col-auto">
                        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                            <div id="datatableCounterInfo">
                                <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                              <span id="datatableCounter">0</span>
                              @lang('Selected')
                            </span>
                                    <a class="btn btn-outline-primary btn-sm me-2" href="javascript:void(0)"
                                       data-bs-toggle="modal"
                                       data-bs-target="#MultipleStatusChange">
                                        <i class="fas fa-undo-alt"></i> @lang('Status Change')
                                    </a>

                                    <a class="btn btn-outline-danger btn-sm me-2" href="javascript:void(0)"
                                       data-bs-toggle="modal"
                                       data-bs-target="#MultipleDelete">
                                        <i class="fas fa-trash"></i> @lang('Delete')
                                    </a>
                                </div>
                            </div>
                            <!-- Filter -->
                            <form>
                                <!-- Search -->
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi-search"></i>
                                    </div>
                                    <input id="datatableWithSearchInput" type="search" class="form-control"
                                           placeholder="@lang('Search Coupon')" aria-label="Search Category">
                                </div>
                                <!-- End Search -->
                            </form>
                            <!-- End Filter -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                    "columnDefs": [{
                      "targets": [0],
                      "orderable": false
                   }],
                   "order": [],
                   "search": "#datatableWithSearchInput",
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatableWithSearchPagination"
                 }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="table-column-pe-0">
                            <div class="form-check">
                                <input class="form-check-input check-all tic-check" type="checkbox"
                                       name="check-all"
                                       id="datatableCheckAll">
                                <label class="form-check-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th scope="col">@lang('SL No.')</th>
                        <th scope="col">@lang('Title')</th>
                        <th scope="col">@lang('Code')</th>
                        <th scope="col">@lang('Discount')</th>
                        <th scope="col">@lang('Apply Game')</th>
                        <th scope="col">@lang('Start Date')</th>
                        <th scope="col">@lang('End Date')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($coupons as $item)
                        <tr>
                            <td class="table-column-pe-0">
                                <div class="form-check">
                                    <input type="checkbox" id="chk-{{$item->id}}"
                                           class="form-check-input row-tic tic-check" name="check" value="{{$item->id}}"
                                           data-id="{{$item->id}}">
                                    <label class="form-check-label" for="chk-{{ $item->id }}"></label>
                                </div>
                            </td>
                            <td data-label="@lang('SL No.')">{{ $loop->index + 1 }}</td>
                            <td data-label="@lang('Title')">{{ $item->title }}</td>
                            <td data-label="@lang('Code')"><h5>{{ $item->code }}</h5></td>
                            <td data-label="@lang('Discount')">
                                <span
                                    class="text-danger">{{ $item->discount }} {{$item->discount_type == 'percent' ? '%':basicControl()->base_currency}}</span>
                            </td>
                            <td data-label="@lang('Module')">
                                <span class="badge bg-soft-dark text-dark ms-1">{{count($item->top_up_list??[]) + count($item->card_list??[])}}</span>
                            </td>
                            <td data-label="@lang('Start Date')">{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y H:i') }}</td>
                            <td data-label="@lang('End Date')">{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d M Y H:i') :'-' }}</td>
                            <td data-label="@lang('Status')">
                                @if($item->check_status == 'Running')
                                    <span class="badge bg-soft-success text-success">
                                        <span class="legend-indicator bg-success"></span>{{$item->check_status}}
                                    </span>
                                @elseif($item->check_status == 'In-Active')
                                    <span class="badge bg-soft-warning text-warning">
                                        <span class="legend-indicator bg-warning"></span>{{$item->check_status}}
                                    </span>
                                @elseif($item->check_status == 'Awaiting-Running')
                                    <span class="badge bg-soft-secondary text-secondary">
                                        <span class="legend-indicator bg-secondary"></span>{{$item->check_status}}
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger">
                                        <span class="legend-indicator bg-danger"></span>{{$item->check_status}}
                                    </span>
                                @endif
                            </td>

                            <td>

                                <a href="{{ route('admin.couponEdit', $item->id) }}"
                                   class="btn btn-white btn-sm">
                                    <i class="bi-pencil-fill me-1"></i> @lang('Edit')
                                </a>


                                <button type="button" class="btn btn-white btn-sm delete_btn" data-bs-toggle="modal"
                                        data-bs-target="#delete"
                                        data-route="{{ route('admin.couponDelete', $item->id) }}">
                                    <i class="bi-trash-fill me-1"></i> @lang('Delete')
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">
                                <div class="text-center p-4">
                                    <img class="dataTables-image mb-3"
                                         src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description"
                                         data-hs-theme-appearance="default">
                                    <img class="dataTables-image mb-3"
                                         src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                         alt="Image Description" data-hs-theme-appearance="dark">
                                    <p class="mb-0">@lang('No data to show')</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="d-flex justify-content-center justify-content-sm-end">
                    <nav id="datatableWithSearchPagination" aria-label="Activity pagination"></nav>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
    </div>
    @include('admin.delete-modal')

@endsection

@push('css-lib')

@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
@endpush

@push('script')
    <script>
        $(document).on('click', '.delete_btn', function () {
            let route = $(this).data('route');
            $('#deleteModalBody').text('Are you sure you want to proceed with the deletion of this coupon?');
            $('.deleteModalRoute').attr('action', route);
        });


        (function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            HSCore.components.HSDatatables.init('.js-datatable', {
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
            })

            $.fn.dataTable.ext.errMode = 'throw';
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


            $(document).on('click', '.change-multiple', function (e) {
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
                    url: "{{ route('admin.couponMultipleStatusChange') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();
                    },
                });
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
                    url: "{{ route('admin.couponMultipleDelete') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();
                    },
                });
            });
        })()
    </script>
@endpush
